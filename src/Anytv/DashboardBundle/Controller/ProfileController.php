<?php

namespace Anytv\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\View\ChoiceView;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;

use Anytv\DashboardBundle\Entity\Affiliate;
use Anytv\DashboardBundle\Entity\AffiliateUser;
use Anytv\DashboardBundle\Form\Type\CompanyType;
use Anytv\DashboardBundle\Form\Type\ProfileType;
use Anytv\DashboardBundle\Entity\TrackingLink;
use Anytv\DashboardBundle\Entity\Conversion;
use Anytv\DashboardBundle\Entity\AffiliateReferralCommission;
use Anytv\DashboardBundle\Entity\SignupAnswer;

class ProfileController extends Controller
{
    public function viewAction(Request $request, $tab, $mode)
    {
      $affiliate_user = $this->getUser();
      $translator = $this->get('translator');
      $em = $this->getDoctrine()->getManager();
      $hasoffers = $this->get('hasoffers');
      
      if (!$affiliate_user) {
        throw $this->createNotFoundException(
            'No user found'
        );
      }
      
      $affiliate = $affiliate_user->getAffiliate();
      
      if (!$affiliate) {
        throw $this->createNotFoundException(
            'No affiliate found'
        );
      }
      
      // paypal auto-retrieve upon profile view
      
      if($affiliate->getPaypalEmailRequested() === false)
      {
        
        
        if($paypal_email = $hasoffers->getPaypalEmail($affiliate->getAffiliateId()))
        {
          $affiliate->setPaypalEmail($paypal_email);
        }
        
        $affiliate->setPaypalEmailRequested(true); 
        
        $em->flush();
        
        // fetch the record again
        $affiliate = $affiliate_user->getAffiliate();
      }
      
      $form = null;
      $form_view = null;
      $errors = array();
      $form_is_posted = false;
      $country_is_listed = true;
      $youtube_network_is_selected = false;
      
      if($mode == 'edit')
      {
        if($tab == 'company')
        {
          $form = $this->createForm(new CompanyType(), $affiliate); 
        }
        elseif($tab == 'user')
        {
          $form = $this->createForm(new ProfileType(), $affiliate_user);  
        }  
        elseif($tab == 'password')
        {
          $form = $this->createFormBuilder()    
          ->add('new_password', 'password', array('label'=>$translator->trans('New Password')))
          ->add('confirm_password', 'password', array('label'=>$translator->trans('Confirm Password')))
          ->add('change', 'submit', array('label'=>$translator->trans('Save')))
          ->getForm();
        }  
        elseif($tab == 'signup_answers')
        {
          if(!$affiliate->getSignupAnswersRequested())
          {
            throw $this->createNotFoundException(
              'An error occurred'
            );
          }
          //$signup_question_repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:SignupQuestion');
          
          //$signup_questions = $signup_question_repository->findAll();
           
          $youtube_networks = array('Acifin', 'AwesomenessTV', 'BBTV', 'Bent Pixels', 'Curse (Union for Gamers)', 'Fullscreen', 'Machinima', 'Maker', 'N4Gtv', 'RPM', 'Social Blade', 'TGN', 'VISO', 'Vultra', 'Yeousch', 'YouTube AdSense', 'ZoominTV');  
          $youtube_network_choices = array_merge($youtube_networks, array('Not Listed'));  
          
          $signup_answers = $affiliate->getSignupAnswers();   
          
          $defaultData = array();
          
          foreach($signup_answers as $signup_answer)
          {
            switch($signup_answer->getQuestion()->getQuestionId())
            {
              case 2:
                $defaultData['youtube_channels'] = $signup_answer->getAnswer();
                break;
              case 4:
                if(in_array($signup_answer->getAnswer(), $youtube_networks))
                {
                  foreach($youtube_networks as $key => $youtube_network)
                  {
                    if($youtube_network == $signup_answer->getAnswer())
                    {
                      $defaultData['youtube_network_choice'] = $key;
                      $youtube_network_is_selected = true;
                      break;
                    }
                  }
                }
                else
                {
                  $defaultData['youtube_network_choice'] = 17;
                  $defaultData['youtube_network'] = $signup_answer->getAnswer();  
                }
                break;
              case 6:
                $defaultData['use_twitch_or_livestream'] = $signup_answer->getAnswer(); 
                break;
              case 8:
                $defaultData['youtube_best_video'] = $signup_answer->getAnswer(); 
                break;
              case 10:
                $defaultData['skype_name'] = $signup_answer->getAnswer();
                break;
              default:
            }
          }
          
          $form_builder = $this->createFormBuilder($defaultData);
                
          foreach($signup_answers as $signup_answer)
          {
            switch($signup_answer->getQuestion()->getQuestionId())
            {
              case 2:
                $form_builder->add('youtube_channels', 'textarea', array('label'=>$translator->trans('Your YouTube Channels (one on each line, write None if you don\'t have one): *')));
                break;
              case 4:
                $form_builder->add('youtube_network_choice', 'choice', array('choices'=>$youtube_network_choices, 'empty_value' => '---', 'label'=>$translator->trans('YouTube Network (who are you partnered with on YouTube): *'), 'required'=>false));
                $form_builder->add('youtube_network', 'textarea', array('label'=>$translator->trans('YouTube Network (other) write None if not partnered: *'), 'required'=>false));
                break;
              case 6:
                $form_builder->add('use_twitch_or_livestream', 'choice', array('choices' => array('none'=>'---', 'Yes'=>'Yes', 'No'=>'No'), 'label'=>$translator->trans('Do you use Twitch or live stream?: *')));
                break;
              case 8:
                $form_builder->add('youtube_best_video', 'textarea', array('label'=>$translator->trans('Link to your best video? (write None if you never made a video): *')));
                break;
              case 10:
                $form_builder->add('skype_name', 'textarea', array('label'=>$translator->trans('Skype Name (write None if you do not use Skype): *')));
                break;
              default:
            }
          }
          
          $form_builder->add('change', 'submit', array('label'=>$translator->trans('Save')));
          
          $form = $form_builder->getForm();
        }  
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            
          $form_is_posted = true;
          
          $em->flush();

          if($tab == 'company')
          {
            // update hasoffers
            $affiliate = $form->getData();
            
            // update affiliate
            $country = $affiliate->getCountry() ? $affiliate->getCountry()->getCode() : '';
            $other = $affiliate->getOther();
            $region = '';
            if(in_array($country, array('US', 'CA')))
            {
              if($country == 'US')
              {
                $region = 'NY';    
              }
              elseif($country == 'CA')
              {
                $region = 'ON';    
              }
            }
          
            $phone = $affiliate->getPhone();
            
            if(substr($phone, 0, 1) == '+')
            {
              $phone = substr_replace($phone, '011', 0, 1);
            }
            
            $fax = $affiliate->getFax();
            
            if(substr($fax, 0, 1) == '+')
            {
              $fax = substr_replace($fax, '011', 0, 1);
            }
            
            $data = array('company'=>$affiliate->getCompany(),
                          'address1'=>$affiliate->getAddress1(),
                          'address2'=>$affiliate->getAddress2(),
                          'city'=>$affiliate->getCity(),
                          'region'=>$region,
                          'country'=>$country,
                          'other'=>$other,
                          'zipcode'=>$affiliate->getZipcode(),
                          'phone'=>$phone,
                          'fax'=>$fax
                         );
            
            
            $affiliate_update_result = $hasoffers->updateAffiliate($affiliate->getAffiliateId(), $data); 
            
            // update affiliate's paypal email
            if($affiliate->getPaypalEmail())
            {
              $affiliate_paypal_update_result = $hasoffers->updatePaypalEmail($affiliate->getAffiliateId(), array('email'=>$affiliate->getPaypalEmail())); 
            }
            else
            {
              $affiliate->setPaypalEmailRequested(false); 
              $em->flush();
            }
            
            return $this->redirect($this->generateUrl('profile_view'));   
          }
          elseif($tab == 'user')
          {
            // update hasoffers
            $affiliate_user = $form->getData();
            
            // update affiliate user
            
            $phone = $affiliate_user->getPhone();
            
            if(substr($phone, 0, 1) == '+')
            {
              $phone = substr_replace($phone, '011', 0, 1);
            }
            
            $cell_phone = $affiliate_user->getCellPhone();
            
            if(substr($cell_phone, 0, 1) == '+')
            {
              $cell_phone = substr_replace($cell_phone, '011', 0, 1);
            }
            
            $data = array('title'=>$affiliate_user->getTitle(),
                          'first_name'=>$affiliate_user->getFirstName(),
                          'last_name'=>$affiliate_user->getLastName(),
                          'phone'=>$phone,
                          'cell_phone'=>$cell_phone
                         );
            
            
            $affiliate_user_update_result = $hasoffers->updateAffiliateUser($affiliate_user->getAffiliateUserId(), $data); 
            
            return $this->redirect($this->generateUrl('profile_view', array('tab'=>'user')));  
          }  
          elseif($tab == 'password')
          {
            $data = $form->getData();
            
            $new_password = $data['new_password'];
            $confirm_password = $data['confirm_password'];
            
            if((($new_password == '') && ($confirm_password = '')) || ($new_password != $confirm_password))
            {
              $errors[] = $translator->trans('Passwords do not match.');   
            }
            
            if(!$errors)
            {
              $new_password = trim($new_password);
              
              $change_password_response = $hasoffers->updateAffiliateUserField($affiliate_user->getAffiliateUserId(), 'password', $new_password, false); 
              $hasoffer_errors = $change_password_response->errors;
              
              if(($change_password_response->status == 1) && $change_password_response->data)
              {
                $factory = $this->get('security.encoder_factory');
                $affiliate_user->setPasswordDecoded($new_password); 
                $encoder = $factory->getEncoder($affiliate_user);
                $hashed_password = $encoder->encodePassword($new_password, $affiliate_user->getSalt());
                $affiliate_user->setPassword($hashed_password);
                $affiliate_user->setLastChangePassword(new \DateTime());
               
                $em->flush();
                
                return $this->redirect($this->generateUrl('profile_view', array('tab'=>'password', 'errors'=>$errors))); 
              }
              else
              {
                $errors[] = $translator->trans($hasoffer_errors[0]->err_msg);    
              }  
            }
          }
          elseif($tab == 'signup_answers')
          {
            $data = $form->getData();
            
            $youtube_channels = strip_tags($data['youtube_channels']);
          
            if($youtube_channels == '')
            {
              $errors[] = $translator->trans('Your YouTube Channels (one on each line, write None if you don\'t have one): *');    
            }
          
            $youtube_network_choice = $data['youtube_network_choice'];
            $youtube_network = strip_tags($data['youtube_network']);
          
            if((is_null($youtube_network_choice) || ($youtube_network_choice == 17)) && ($youtube_network == ''))
            {
              $errors[] = $translator->trans('YouTube Network (who are you partnered with on YouTube, write None if not partnered): *');    
            }
          
            $youtube_network_is_selected = in_array($youtube_network_choice, range(0, 16));
          
            $use_twitch_or_livestream = strip_tags($data['use_twitch_or_livestream']);
          
            if($use_twitch_or_livestream == 'none')
            {
              $errors[] = $translator->trans('Do you use Twitch or live stream?: *');    
            }
          
            $youtube_best_video = strip_tags($data['youtube_best_video']);
          
            if($youtube_best_video == '')
            {
              $errors[] = $translator->trans('Link to your best video? (write None if you never made a video): *');    
            }
          
            $skype_name = strip_tags($data['skype_name']);
          
            if($skype_name == '')
            {
              $errors[] = $translator->trans('Skype Name (write None if you do not use Skype): *');    
            }
            
            if(!$errors)
            {
              // send signup answers to hasoffers
              foreach($signup_answers as $signup_answer)
              {
                switch($signup_answer->getQuestion()->getQuestionId())
                {
                  case 2:
                    if($youtube_channels)
                    {
                      $signup_answer_response = $hasoffers->updateSignupQuestionAnswer($signup_answer->getAnswerId(), $youtube_channels);
                      $signup_answer->setAnswer($youtube_channels);
                    }
                    break;
                  case 4:
                    if($youtube_network_is_selected)
                    {
                      $youtube_network = $youtube_network_choices[$youtube_network_choice];
                      $signup_answer_response = $hasoffers->updateSignupQuestionAnswer($signup_answer->getAnswerId(), $youtube_network);
                      $signup_answer->setAnswer($youtube_network);
                    }
                    elseif($youtube_network)
                    {
                      $signup_answer_response = $hasoffers->updateSignupQuestionAnswer($signup_answer->getAnswerId(), $youtube_network);
                      $signup_answer->setAnswer($youtube_network);
                    }
                    break;
                  case 6:
                    if($use_twitch_or_livestream != 'none')
                    {
                      $signup_answer_response = $hasoffers->updateSignupQuestionAnswer($signup_answer->getAnswerId(), $use_twitch_or_livestream);
                      $signup_answer->setAnswer($use_twitch_or_livestream);
                    } 
                    break;
                  case 8:
                    if($youtube_best_video)
                    {
                      $signup_answer_response = $hasoffers->updateSignupQuestionAnswer($signup_answer->getAnswerId(), $youtube_best_video);
                      $signup_answer->setAnswer($youtube_best_video);
                    }
                    break;
                  case 10:
                    if($skype_name)
                    {
                      $signup_answer_response = $hasoffers->updateSignupQuestionAnswer($signup_answer->getAnswerId(), $skype_name);
                      $signup_answer->setAnswer($skype_name);
                    }
                    break;
                  default:
                }
              }  
              
              $em->flush();
               
              return $this->redirect($this->generateUrl('profile_view', array('tab'=>'signup_answers'))); 
            }
          }
        }
        
        $form_view = $form->createView();
      }

      return $this->render('AnytvDashboardBundle:Profile:view.html.twig', array('title'=>$affiliate, 'affiliate_user'=>$affiliate_user, 'affiliate'=>$affiliate, 'affiliate_user_status'=>$translator->trans($affiliate_user->getStatus()), 'affiliate_status'=>$translator->trans($affiliate->getStatus()), 'tab'=>$tab, 'mode'=>$mode, 'form'=>$form_view, 'errors'=>$errors, 'form_is_posted'=>$form_is_posted, 'country_is_listed'=>$country_is_listed, 'youtube_network_is_selected'=>$youtube_network_is_selected));
    }   
    
    public function reportsAction(Request $request)
    {
      $affiliate_user = $this->getUser();
      $translator = $this->get('translator');
      
      if (!$affiliate_user) {
        throw $this->createNotFoundException(
            'No user found'
        );
      }
      
      $affiliate = $affiliate_user->getAffiliate();
      
      if (!$affiliate) {
        throw $this->createNotFoundException(
            'No affiliate found'
        );
      }
      
      return $this->render('AnytvDashboardBundle:Profile:reports.html.twig', array('title'=>$affiliate, 'affiliate_user'=>$affiliate_user, 'affiliate'=>$affiliate, 'tab'=>'referrals'));
    }
    
    public function companyEditAction(Request $request)
    {
      $affiliate_user = $this->getUser();
      
      $affiliate = $affiliate_user->getAffiliate();

      if (!$affiliate) {
        throw $this->createNotFoundException(
            'No affiliate found for id '.$id
        );
      }

      $form = $this->createForm(new CompanyType(), $affiliate);

      $form->handleRequest($request);

      if ($form->isValid()) {
        
        $affiliate = $form->getData();
        
        $em = $this->getDoctrine()->getManager();
        
        $em->persist($affiliate);
        $em->flush();

        return $this->redirect($this->generateUrl('profile_view'));
      }

      return $this->render('AnytvDashboardBundle:Profile:companyEdit.html.twig', array('title'=>'Edit '.$affiliate, 'form'=>$form->createView(), 'affiliate'=>$affiliate, 'affiliate_user'=>$affiliate_user));
    }
    
    public function idCardAction($affiliate, $affiliate_user, $page)
    {
      $commission_rate_repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:AffiliateReferralCommission');
      
      $commission_rate = $commission_rate_repository->findOneBy(array('affiliateId'=>$affiliate->getAffiliateId()));
      
      if($commission_rate)
      {
        $commission_rate_percent = $commission_rate->getRate();    
      }
      else
      {
        $commission_rate_percent = null;
        $hasoffers = $this->get('hasoffers');
        $commission_rate_response = $hasoffers->getReferralCommission($affiliate->getAffiliateId());     
              
        if(($commission_rate_response->status == 1) && $commission_rate_response->data)
        {
          $em = $this->getDoctrine()->getManager();
          
          $commission_rate_object = $commission_rate_response->data->AffiliateReferralCommission;
          
          $commission_rate_percent = $commission_rate_object->rate;
          
          $affiliate_referral_commission = new AffiliateReferralCommission();
          $affiliate_referral_commission->setAffiliateId($commission_rate_object->affiliate_id);
          $affiliate_referral_commission->setField($commission_rate_object->field);
          $affiliate_referral_commission->setRateType($commission_rate_object->rate_type);
          $affiliate_referral_commission->setRate($commission_rate_object->rate);
          //$affiliate_referral_commission->setMinCommission($commission_rate_object->min_commission);
          
          $em->persist($affiliate_referral_commission);
          $em->flush();
        }    
      }
      
      return $this->render('AnytvDashboardBundle:Profile:idCard.html.twig', array('affiliate'=>$affiliate, 'affiliate_user'=>$affiliate_user, 'page'=>$page, 'commission_rate_percent'=>$commission_rate_percent));
    }
    
    public function tabbedComponentAction($affiliate, $affiliate_user)
    {
      return $this->render('AnytvDashboardBundle:Profile:tabbedComponent.html.twig', array('affiliate'=>$affiliate, 'affiliate_user'=>$affiliate_user));
    }
    
    public function tabbedProfileComponentAction($tab, $mode, $form, $errors, $affiliate, $form_is_posted, $youtube_network_is_selected)
    {
      return $this->render('AnytvDashboardBundle:Profile:tabbedProfileComponent.html.twig', array('tab'=>$tab, 'mode'=>$mode, 'form'=>$form, 'errors'=>$errors, 'affiliate'=>$affiliate, 'form_is_posted'=>$form_is_posted, 'youtube_network_is_selected'=>$youtube_network_is_selected));
    }
    
    public function tabbedReportsComponentAction($affiliate, $affiliate_user)
    {
      return $this->render('AnytvDashboardBundle:Profile:tabbedReportsComponent.html.twig', array('affiliate'=>$affiliate, 'affiliate_user'=>$affiliate_user));
    }
     
    public function myOffersAction(Request $request, $page)
    {
      $affiliate_user = $this->getUser();

      if (!$affiliate_user) {
        throw $this->createNotFoundException(
            'No user found'
        );
      }
      
      $affiliate = $affiliate_user->getAffiliate();
      
      return $this->render('AnytvDashboardBundle:Profile:myOffers.html.twig', array('affiliate'=>$affiliate, 'affiliate_user'=>$affiliate_user, 'page'=>$page));
    }
    
    public function browseOffersAction(Request $request, $page)
    {
      $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Offer');
      $offer_category_repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:OfferCategory');
      $country_repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Country');
      
      $session = $this->get('session');
      
      $keyword = $request->get('offer_keyword', null);
      $category = $request->get('offer_category', null);
      $country = $request->get('offer_country', null);
      
      if($request->request->has('offer_form_submitted'))
      {
        $session->set('offer_keyword', $keyword);
        $session->set('offer_category', $category);
        $session->set('offer_country', $country);
      }
      
      $affiliate_user = $this->getUser();

      if (!$affiliate_user) {
        throw $this->createNotFoundException(
            'No user found'
        );
      }
      
      $affiliate = $affiliate_user->getAffiliate();
      
      $items_per_page = 10;
      $order_by = 'name';
      $order = 'ASC';
        
      $offers = $repository->findAllOffers($page, $items_per_page, $order_by, $order, $session->get('offer_keyword', null), 'active', $session->get('offer_category', null), $session->get('offer_country', null), true);
      $total_offers = $repository->countAllOffers($session->get('offer_keyword', null), 'active', $session->get('offer_category', null), $session->get('offer_country', null), true);
      $total_pages = ceil($total_offers / $items_per_page);
      
      $offer_categories = $offer_category_repository->findAll();
      
      $countries = $country_repository->findAll();

      return $this->render('AnytvDashboardBundle:Profile:browseOffers.html.twig', array('affiliate'=>$affiliate, 'affiliate_user'=>$affiliate_user, 'offers'=>$offers, 'total_offers'=>$total_offers, 'page'=>$page, 'total_pages'=>$total_pages, 'countries'=>$countries, 'offer_categories'=>$offer_categories, 'offer_keyword'=>$session->get('offer_keyword', null), 'selected_offer_category'=>$session->get('offer_category', null), 'selected_offer_country'=>$session->get('offer_country')));
    }
    
    public function myReferralsAction(Request $request, $page)
    {
      $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Referral');
      $commission_rate_repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:AffiliateReferralCommission');
      $translator = $this->get('translator');
      $session = $this->get('session');
      $affiliate_user = $this->getUser();

      if (!$affiliate_user) {
        throw $this->createNotFoundException(
            'No user found'
        );
      }
      
      $affiliate = $affiliate_user->getAffiliate();
      
      $start_date = $session->get('referral_start_date', new \DateTime(date('Y-m-d', strtotime('2013-02-11'))));
      $end_date = $session->get('referral_end_date', new \DateTime(date('Y-m-d')));
      
      $form = $this->createFormBuilder(array('referral_hide_zeros'=>$session->get('referral_hide_zeros', false), 'referral_start_date'=>$start_date, 'referral_end_date'=>$end_date))
        ->add('referral_hide_zeros', 'checkbox', array('label'=>$translator->trans('Hide $0 earnings'), 'required'=>false))
        ->add('referral_start_date', 'date', array('label'=>$translator->trans('From'), 'required'=>false, 'widget' => 'single_text', 'format'=>'yyyy-MM-dd', 'attr' => array('class' => 'date form-control input')))
        ->add('referral_end_date', 'date', array('label'=>$translator->trans('To'), 'required'=>false, 'widget' => 'single_text', 'format'=>'yyyy-MM-dd', 'attr' => array('class' => 'date form-control input')))
        ->getForm();
        
      $form->handleRequest($request);
        
      if($form->isValid()) 
      {
        $data = $form->getData();
        $session->set('referral_hide_zeros', $data['referral_hide_zeros']); 
        $session->set('referral_start_date', $data['referral_start_date']); 
        $session->set('referral_end_date', $data['referral_end_date']); 
        
        $start_date = $session->get('referral_start_date', new \DateTime(date('Y-m-d', strtotime('2013-02-11'))));
        $end_date = $session->get('referral_end_date', new \DateTime(date('Y-m-d')));
      }
      
      $items_per_page = 10;
      $order_by = 'id';
      $order = 'DESC';
      $graph_order = 'ASC';
        
      $referrals = $repository->findAllReferrals($page, $items_per_page, $order_by, $order, $affiliate, $session->get('referral_hide_zeros', 0), $session->get('referral_start_date', new \DateTime(date('Y-m-d', strtotime('2013-02-11')))), $session->get('referral_end_date', new \DateTime(date('Y-m-d'))));
      $total_referrals = $repository->countAllReferrals($affiliate, $session->get('referral_hide_zeros', 0), $session->get('referral_start_date', new \DateTime(date('Y-m-d', strtotime('2013-02-11')))), $session->get('referral_end_date', new \DateTime(date('Y-m-d'))));
      $total_pages = ceil($total_referrals / $items_per_page);
      
      $commission_rate = $commission_rate_repository->findOneBy(array('affiliateId'=>$affiliate->getAffiliateId()));
      
      if($commission_rate)
      {
        $commission_rate_percent = $commission_rate->getRate();    
      }
      else
      {
        $commission_rate_percent = null;
        $hasoffers = $this->get('hasoffers');
        $commission_rate_response = $hasoffers->getReferralCommission($affiliate->getAffiliateId());     
              
        if(($commission_rate_response->status == 1) && $commission_rate_response->data)
        {
          $em = $this->getDoctrine()->getManager();
          
          $commission_rate_object = $commission_rate_response->data->AffiliateReferralCommission;
          
          $commission_rate_percent = $commission_rate_object->rate;
          
          $affiliate_referral_commission = new AffiliateReferralCommission();
          $affiliate_referral_commission->setAffiliateId($commission_rate_object->affiliate_id);
          $affiliate_referral_commission->setField($commission_rate_object->field);
          $affiliate_referral_commission->setRateType($commission_rate_object->rate_type);
          $affiliate_referral_commission->setRate($commission_rate_object->rate);
          //$affiliate_referral_commission->setMinCommission($commission_rate_object->min_commission);
          
          $em->persist($affiliate_referral_commission);
          $em->flush();
        }    
      }
      
      $graph_referrals = $repository->findAllReferralsForGraph($order_by, $graph_order, $affiliate, $session->get('referral_hide_zeros', 0), $start_date, $end_date);
      
      $strDateFrom = date_format($start_date, 'Y-m-d');
      $strDateTo = date_format($end_date, 'Y-m-d');
      
      $aryRange = array();

      $iDateFrom = mktime(1, 0, 0, substr($strDateFrom,5,2), substr($strDateFrom,8,2),substr($strDateFrom,0,4));
      $iDateTo = mktime(1, 0, 0, substr($strDateTo,5,2), substr($strDateTo,8,2),substr($strDateTo,0,4));

      if ($iDateTo >= $iDateFrom)
      {
        $aryRange[date('Y-m-d', $iDateFrom)] = 0;
        while ($iDateFrom < $iDateTo)
        {
            $iDateFrom += 86400;
            $aryRange[date('Y-m-d', $iDateFrom)] = 0;
        }
      }
      
      $max_amount = 0;
      foreach($graph_referrals as $graph_referral)
      {
        $aryRange[$graph_referral->getDateAsString()] += $graph_referral->getAmount(); 
        
        if($aryRange[$graph_referral->getDateAsString()] > $max_amount)
        {
          $max_amount = $aryRange[$graph_referral->getDateAsString()];        
        }
      }

      return $this->render('AnytvDashboardBundle:Profile:myReferrals.html.twig', array('affiliate'=>$affiliate, 'affiliate_user'=>$affiliate_user, 'referrals'=>$referrals, 'total_pages'=>$total_pages, 'page'=>$page, 'form'=>$form->createView(), 'commission_rate_percent'=>$commission_rate_percent, 'max_amount'=>$max_amount, 'aryRange'=>$aryRange));
    }
    
    public function myReferralsExportCsvAction(Request $request)
    {
      $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Referral');
      $translator = $this->get('translator');
      $session = $this->get('session');
      $affiliate_user = $this->getUser();

      if (!$affiliate_user) {
        throw $this->createNotFoundException(
            'No user found'
        );
      }
      
      $affiliate = $affiliate_user->getAffiliate();
      
      $referral_hide_zeros = $session->get('referral_hide_zeros', false);
      $start_date = $session->get('referral_start_date', new \DateTime(date('Y-m-d', strtotime('2013-02-11'))));
      $end_date = $session->get('referral_end_date', new \DateTime(date('Y-m-d')));
      $order_by = 'id';
      $order = 'DESC';
      
      $referrals = $repository->findAllAffiliateReferrals($order_by, $order, $affiliate, $referral_hide_zeros, $start_date, $end_date);
      
      ob_start();
      
      $filename = $translator->trans('Referrals').'-'.$start_date->format('Y-m-d').'-'.$end_date->format('Y-m-d').'.csv';
      $response = new Response();
      $response->headers->set('Content-Type', 'text/csv');
      $response->headers->set('Content-Disposition', 'attachment; filename="'.$filename.'"');
        
      $response->sendHeaders();
      	
      $output = fopen('php://output', 'w');
      
      fputcsv($output, array($translator->trans('Time'), 
                             $translator->trans('Affiliate'),
                             $translator->trans('Your commission'),
                             $translator->trans('Their earnings')
              ));
      
      if($referrals)
      {
        foreach($referrals as $referral)
        {
          fputcsv($output, array($referral->getDateAsString(), $referral->getReferred(), '$'.$referral->getAmount(), '$'.$referral->getTotal()));
        }
      }
      
      fclose($output);

      return $response;
    }
    
    public function myReferralListAction($page)
    {
      $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Affiliate');
      $affiliate_user = $this->getUser();

      if (!$affiliate_user) {
        throw $this->createNotFoundException(
            'No user found'
        );
      }
      
      $affiliate = $affiliate_user->getAffiliate();
      
      $items_per_page = 10;
      $order_by = 'dateAdded';
      $order = 'DESC';
      $graph_order_by = 'dateAdded';
      $graph_order = 'ASC';
      
      $referred_affiliates = $repository->findAllAffiliatesByReferrer($affiliate, $page, $items_per_page, $order_by, $order);
      $total_referred_affiliates = $repository->countAllAffiliatesByReferrer($affiliate);
      $total_pages = ceil($total_referred_affiliates / $items_per_page);
      
      $graph_referred_affiliates = $repository->findAllReferredAffiliatesForGraph($graph_order_by, $graph_order, $affiliate);
      
      $strDateFrom = date_format(new \DateTime(date('Y-m-d', strtotime('2013-01-10'))), 'Y-m-d');
      $strDateTo = date_format(new \DateTime(date('Y-m-d')), 'Y-m-d');
      
      $aryRange = array();

      $iDateFrom = mktime(1, 0, 0, substr($strDateFrom,5,2), substr($strDateFrom,8,2),substr($strDateFrom,0,4));
      $iDateTo = mktime(1, 0, 0, substr($strDateTo,5,2), substr($strDateTo,8,2),substr($strDateTo,0,4));

      if ($iDateTo >= $iDateFrom)
      {
        $aryRange[date('Y-m-d', $iDateFrom)] = 0;
        while ($iDateFrom < $iDateTo)
        {
            $iDateFrom += 86400;
            $aryRange[date('Y-m-d', $iDateFrom)] = 0;
        }
      }
      
      $max_referrals = 0;
      foreach($graph_referred_affiliates as $graph_referred_affiliate)
      {
        $aryRange[$graph_referred_affiliate->getDateAddedAsString()]++; 
        
        if($aryRange[$graph_referred_affiliate->getDateAddedAsString()] > $max_referrals)
        {
          $max_referrals = $aryRange[$graph_referred_affiliate->getDateAddedAsString()];        
        }
      }

      return $this->render('AnytvDashboardBundle:Profile:myReferralList.html.twig', array('affiliate'=>$affiliate, 'affiliate_user'=>$affiliate_user, 'referred_affiliates'=>$referred_affiliates, 'total_pages'=>$total_pages, 'page'=>$page, 'max_referrals'=>$max_referrals, 'aryRange'=>$aryRange));
    }
    
    public function myConversionsAction(Request $request, $page)
    {
      $translator = $this->get('translator');
      $session = $this->get('session');
      $conversion_repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Conversion');
      $affiliate_user = $this->getUser();

      if (!$affiliate_user) {
        throw $this->createNotFoundException(
            'No user found'
        );
      }
      
      $affiliate = $affiliate_user->getAffiliate();
      
      $start_date = $session->get('conversion_start_date', new \DateTime(date('Y-m-d', strtotime('2013-01-20'))));
      $end_date = $session->get('conversion_end_date', new \DateTime(date('Y-m-d')));
      
      $form = $this->createFormBuilder(array('conversion_start_date'=>$start_date, 'conversion_end_date'=>$end_date))
        ->add('conversion_start_date', 'date', array('label'=>$translator->trans('From'), 'required'=>false, 'widget' => 'single_text', 'format'=>'yyyy-MM-dd', 'attr' => array('class' => 'date form-control input')))
        ->add('conversion_end_date', 'date', array('label'=>$translator->trans('To'), 'required'=>false, 'widget' => 'single_text', 'format'=>'yyyy-MM-dd', 'attr' => array('class' => 'date form-control input')))
        ->getForm();
        
      $form->handleRequest($request);
        
      if($form->isValid()) 
      {
        $data = $form->getData();
        $session->set('conversion_start_date', $data['conversion_start_date']); 
        $session->set('conversion_end_date', $data['conversion_end_date']); 
        
        $start_date = $session->get('conversion_start_date', new \DateTime(date('Y-m-d', strtotime('2013-01-20'))));
        $end_date = $session->get('conversion_end_date', new \DateTime(date('Y-m-d')));
      }
      
      $items_per_page = 10;
      $order_by = 'createdAt';
      $order = 'DESC';
      $graph_order = 'ASC';
        
      $conversions = $conversion_repository->findAllConversions($page, $items_per_page, $order_by, $order, $affiliate, $start_date, $end_date);
      $total_conversions = $conversion_repository->countAllConversions($affiliate, $start_date, $end_date);
      $total_pages = ceil($total_conversions / $items_per_page);
      
      $graph_conversions = $conversion_repository->findAllConversionsForGraph($order_by, $graph_order, $affiliate, $start_date, $end_date);
      
      $strDateFrom = date_format($start_date, 'Y-m-d');
      $strDateTo = date_format($end_date, 'Y-m-d');
      
      $aryRange = array();

      $iDateFrom = mktime(1, 0, 0, substr($strDateFrom,5,2), substr($strDateFrom,8,2),substr($strDateFrom,0,4));
      $iDateTo = mktime(1, 0, 0, substr($strDateTo,5,2), substr($strDateTo,8,2),substr($strDateTo,0,4));

      if ($iDateTo >= $iDateFrom)
      {
        $aryRange[date('Y-m-d', $iDateFrom)] = 0;
        while ($iDateFrom < $iDateTo)
        {
            $iDateFrom += 86400;
            $aryRange[date('Y-m-d', $iDateFrom)] = 0;
        }
      }
      
      $max_payout = 0;
      foreach($graph_conversions as $graph_conversion)
      {
        $aryRange[$graph_conversion->getCreatedAtAsString()] += $graph_conversion->getPayout(); 
        
        if($aryRange[$graph_conversion->getCreatedAtAsString()] > $max_payout)
        {
          $max_payout = $aryRange[$graph_conversion->getCreatedAtAsString()];        
        }
      }

      return $this->render('AnytvDashboardBundle:Profile:myConversions.html.twig', array('affiliate'=>$affiliate, 'affiliate_user'=>$affiliate_user, 'conversions'=>$conversions, 'total_pages'=>$total_pages, 'page'=>$page, 'form'=>$form->createView(), 'aryRange'=>$aryRange, 'max_payout'=>$max_payout));
    }
    
    public function myConversionsExportCsvAction(Request $request)
    {
      $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Conversion');
      $translator = $this->get('translator');
      $session = $this->get('session');
      $affiliate_user = $this->getUser();

      if (!$affiliate_user) {
        throw $this->createNotFoundException(
            'No user found'
        );
      }
      
      $affiliate = $affiliate_user->getAffiliate();
      
      $start_date = $session->get('conversion_start_date', new \DateTime(date('Y-m-d', strtotime('2013-01-20'))));
      $end_date = $session->get('conversion_end_date', new \DateTime(date('Y-m-d')));
      $order_by = 'createdAt';
      $order = 'DESC';
      
      $conversions = $repository->findAllAffiliateConversions($order_by, $order, $affiliate, $start_date, $end_date);
      
      ob_start();
      
      $filename = $translator->trans('Conversions').'-'.$start_date->format('Y-m-d').'-'.$end_date->format('Y-m-d').'.csv';
      $response = new Response();
      $response->headers->set('Content-Type', 'text/csv');
      $response->headers->set('Content-Disposition', 'attachment; filename="'.$filename.'"');
      
      $response->sendHeaders();
      	
      $output = fopen('php://output', 'w');
      
      fputcsv($output, array($translator->trans('Time'), 
                             $translator->trans('Offer'),
                             $translator->trans('Status'),
                             $translator->trans('Payout'),
                             $translator->trans('Conversion IP'),
                             $translator->trans('Transaction ID')
              ));
      
      if($conversions)
      {
        foreach($conversions as $conversion)
        {
          fputcsv($output, array($conversion->getCreatedAtAsString(), $conversion->getOffer(), $conversion->getStatus(), '$'.$conversion->getPayout(), $conversion->getIp(), $conversion->getTransactionId()));
        }
      }
      
      fclose($output);

      return $response;
    }
    
    public function partnersAction(Request $request, $page)
    {
      if(!$request->isXmlHttpRequest())
      {
        throw $this->createNotFoundException(
            'Invalid request'
        );
      }
      
      $affiliate_user = $this->getUser();

      if (!$affiliate_user) {
        throw $this->createNotFoundException(
            'No user found'
        );
      }
      
      $affiliate = $affiliate_user->getAffiliate();
      
      return $this->render('AnytvDashboardBundle:Profile:partners.html.twig', array('affiliate'=>$affiliate, 'affiliate_user'=>$affiliate_user, 'page'=>$page));
    }
    
    public function offerViewAction(Request $request, $id)
    {
      if(!$request->isXmlHttpRequest())
      {
        throw $this->createNotFoundException(
            'Invalid request'
        );
      }
      
      $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Offer');
      //$country_repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Country');
      $offer_group_repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:OfferGroup');
      $tracking_link_repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:TrackingLink');
      //$translator = $this->get('translator');
      
      $offer = $repository->find($id);

      if (!$offer) {
        throw $this->createNotFoundException(
            'No offer found for id '.$id
        );
      }
      
      $affiliate_user = $this->getUser();
   
      if (!$affiliate_user) {
        throw $this->createNotFoundException(
            'No user found'
        );
      }
      
      $affiliate = $affiliate_user->getAffiliate();
      
      if (!$affiliate) {
        throw $this->createNotFoundException(
            'No affiliate found'
        );
      }
      
      $tracking_link = $tracking_link_repository->findOneBy(array('affiliateId'=>$affiliate->getAffiliateId(), 'offerId'=>$offer->getOfferId()));
      
      if(!$tracking_link)
      {
        $hasoffers = $this->get('hasoffers');
        $tracking_link_hasoffers = $hasoffers->getPlayNowLink($offer->getOfferId(), $affiliate->getAffiliateId());
        
        if($tracking_link_hasoffers)
        {
          $manager = $this->getDoctrine()->getManager();
          
          $tracking_link = new TrackingLink();
          $tracking_link->setAffiliateId($tracking_link_hasoffers->affiliate_id);
          $tracking_link->setOfferId($tracking_link_hasoffers->offer_id);
          $tracking_link->setClickUrl($tracking_link_hasoffers->click_url);
          
          $manager->persist($tracking_link);   
          $manager->flush();
        }
      }
      
      $offer_categories = $offer->getOfferCategories();
      $offer_group = $offer_group_repository->findOneOfferGroupByOffer($id);
      $countries = $offer->getCountries();

      return $this->render('AnytvDashboardBundle:Profile:offerView.html.twig', array('offer'=>$offer, 'offer_categories'=>$offer_categories, 'offer_group'=>$offer_group, 'countries'=>$countries, 'tracking_link'=>$tracking_link));
    }
    
    public function myVideosAction(Request $request, $page)
    {
      if(!$request->isXmlHttpRequest())
      {
        throw $this->createNotFoundException(
            'Invalid request'
        );
      }
      
      $affiliate_user = $this->getUser();

      if (!$affiliate_user) {
        throw $this->createNotFoundException(
            'No user found'
        );
      }
      
      $affiliate = $affiliate_user->getAffiliate();
      
      return $this->render('AnytvDashboardBundle:Profile:myVideos.html.twig', array('affiliate'=>$affiliate, 'affiliate_user'=>$affiliate_user, 'page'=>$page));
    }
    
    public function companyAction(Request $request, $mode, $form)
    {
      $translator = $this->get('translator');
      $affiliate_user = $this->getUser();

      if (!$affiliate_user) {
        throw $this->createNotFoundException(
            'No user found'
        );
      }
      
      $affiliate = $affiliate_user->getAffiliate();
      
      return $this->render('AnytvDashboardBundle:Profile:company.html.twig', array('affiliate'=>$affiliate, 'mode'=>$mode, 'form'=>$form));
    }
    
    public function userAction(Request $request, $mode, $form)
    {
      $translator = $this->get('translator');
      $affiliate_user = $this->getUser();

      if (!$affiliate_user) {
        throw $this->createNotFoundException(
            'No user found'
        );
      }
      
      $affiliate = $affiliate_user->getAffiliate();
      
      return $this->render('AnytvDashboardBundle:Profile:user.html.twig', array('title'=>$affiliate, 'affiliate_user'=>$affiliate_user, 'affiliate'=>$affiliate, 'affiliate_user_status'=>$translator->trans($affiliate_user->getStatus()), 'affiliate_status'=>$translator->trans($affiliate->getStatus()), 'mode'=>$mode, 'form'=>$form));
    }
    
    public function passwordAction(Request $request, $mode, $form, $errors)
    {
      $translator = $this->get('translator');
      $affiliate_user = $this->getUser();

      if (!$affiliate_user) {
        throw $this->createNotFoundException(
            'No user found'
        );
      }
      
      $affiliate = $affiliate_user->getAffiliate();
      
      return $this->render('AnytvDashboardBundle:Profile:password.html.twig', array('title'=>$affiliate, 'affiliate_user'=>$affiliate_user, 'affiliate'=>$affiliate, 'affiliate_user_status'=>$translator->trans($affiliate_user->getStatus()), 'affiliate_status'=>$translator->trans($affiliate->getStatus()), 'mode'=>$mode, 'form'=>$form, 'errors'=>$errors));
    }
    
    public function offerViewPopupAction()
    {
      return $this->render('AnytvDashboardBundle:Profile:offerViewPopup.html.twig');
    }
    
    public function trafficAction(Request $request)
    {
      $affiliate_user = $this->getUser();
      $translator = $this->get('translator');
      
      if (!$affiliate_user) {
        throw $this->createNotFoundException(
            'No user found'
        );
      }
      
      $affiliate = $affiliate_user->getAffiliate();
      
      if (!$affiliate) {
        throw $this->createNotFoundException(
            'No affiliate found'
        );
      }
      
      return $this->render('AnytvDashboardBundle:Profile:traffic.html.twig', array('title'=>$affiliate, 'affiliate_user'=>$affiliate_user, 'affiliate'=>$affiliate, 'tab'=>'traffic'));
    }
    
    public function tabbedTrafficComponentAction($affiliate, $affiliate_user)
    {
      return $this->render('AnytvDashboardBundle:Profile:tabbedTrafficComponent.html.twig', array('affiliate'=>$affiliate, 'affiliate_user'=>$affiliate_user));
    }
    
    public function trafficReferralsAction(Request $request, $page)
    {
      $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:TrafficReferral');
      $translator = $this->get('translator');
      $session = $this->get('session');
      $affiliate_user = $this->getUser();

      if (!$affiliate_user) {
        throw $this->createNotFoundException(
            'No user found'
        );
      }
      
      $affiliate = $affiliate_user->getAffiliate();
      
      $start_date = $session->get('traffic_referral_start_date', new \DateTime(date('Y-m-d', strtotime('2013-01-10'))));
      $end_date = $session->get('traffic_referral_end_date', new \DateTime(date('Y-m-d')));
      
      $form = $this->createFormBuilder(array('traffic_referral_category'=>$session->get('traffic_referral_category', null),'traffic_referral_start_date'=>$start_date, 'traffic_referral_end_date'=>$end_date))
        ->add('traffic_referral_start_date', 'date', array('label'=>$translator->trans('From'), 'required'=>false, 'widget' => 'single_text', 'format'=>'yyyy-MM-dd', 'attr' => array('class' => 'date form-control input')))
        ->add('traffic_referral_end_date', 'date', array('label'=>$translator->trans('To'), 'required'=>false, 'widget' => 'single_text', 'format'=>'yyyy-MM-dd', 'attr' => array('class' => 'date form-control input')))
        ->add('traffic_referral_category', 'choice', array('required' => false, 'choices' => array('youtube'=>'Youtube', 'twitch'=>'Twitch', 'websites'=>'Websites'), 'label'=>$translator->trans('Category')))
        ->getForm();
        
      $form->handleRequest($request);
        
      if($form->isValid()) 
      {
        $data = $form->getData();
        $session->set('traffic_referral_category', $data['traffic_referral_category']); 
        $session->set('traffic_referral_start_date', $data['traffic_referral_start_date']); 
        $session->set('traffic_referral_end_date', $data['traffic_referral_end_date']); 
        
        $start_date = $session->get('traffic_referral_start_date', new \DateTime(date('Y-m-d', strtotime('2013-01-10'))));
        $end_date = $session->get('traffic_referral_end_date', new \DateTime(date('Y-m-d')));
      }
      
      $items_per_page = 10;
      $order_by = 'statDate';
      $order = 'DESC';
      $graph_order = 'ASC';
        
      $traffic_referrals = $repository->findAllTrafficReferralsByAffiliate($page, $items_per_page, $order_by, $order, $affiliate, false, $start_date, $end_date, $session->get('traffic_referral_category', null));
      $total_traffic_referrals = $repository->countAllTrafficReferralsByAffiliate($affiliate, false, $start_date, $end_date, $session->get('traffic_referral_category', null));
      $total_pages = ceil($total_traffic_referrals / $items_per_page);
      
      $graph_traffic_referrals = $repository->findAlltrafficReferralsForGraph($order_by, $graph_order, $affiliate, false, $start_date, $end_date, $session->get('traffic_referral_category', null));
      
      $strDateFrom = date_format($start_date, 'Y-m-d');
      $strDateTo = date_format($end_date, 'Y-m-d');
      
      $aryRange = array();

      $iDateFrom = mktime(1, 0, 0, substr($strDateFrom,5,2), substr($strDateFrom,8,2),substr($strDateFrom,0,4));
      $iDateTo = mktime(1, 0, 0, substr($strDateTo,5,2), substr($strDateTo,8,2),substr($strDateTo,0,4));

      if ($iDateTo >= $iDateFrom)
      {
        $aryRange[date('Y-m-d', $iDateFrom)] = 0;
        while ($iDateFrom < $iDateTo)
        {
            $iDateFrom += 86400;
            $aryRange[date('Y-m-d', $iDateFrom)] = 0;
        }
      }
      
      $max_clicks = 0;
      foreach($graph_traffic_referrals as $graph_traffic_referral)
      {
        $aryRange[$graph_traffic_referral->getStatDateAsString()] += $graph_traffic_referral->getClicks(); 
        
        if($aryRange[$graph_traffic_referral->getStatDateAsString()] > $max_clicks)
        {
          $max_clicks = $aryRange[$graph_traffic_referral->getStatDateAsString()];        
        }
      }

      return $this->render('AnytvDashboardBundle:Profile:trafficReferrals.html.twig', array('affiliate'=>$affiliate, 'affiliate_user'=>$affiliate_user, 'traffic_referrals'=>$traffic_referrals, 'total_pages'=>$total_pages, 'page'=>$page, 'form'=>$form->createView(), 'selected_traffic_referral_category'=>$session->get('selected_traffic_referral_category', null), 'max_clicks'=>$max_clicks, 'aryRange'=>$aryRange));
    }
    
    public function trafficReferralsExportCsvAction(Request $request)
    {
      $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:TrafficReferral');
      $translator = $this->get('translator');
      $session = $this->get('session');
      $affiliate_user = $this->getUser();

      if (!$affiliate_user) {
        throw $this->createNotFoundException(
            'No user found'
        );
      }
      
      $affiliate = $affiliate_user->getAffiliate();
      
      $start_date = $session->get('traffic_referral_start_date', new \DateTime(date('Y-m-d', strtotime('2013-01-10'))));
      $end_date = $session->get('traffic_referral_end_date', new \DateTime(date('Y-m-d')));
      $order_by = 'statDate';
      $order = 'DESC';
      
      $traffic_referrals = $repository->findAllAffiliateTrafficReferrals($order_by, $order, $affiliate, $start_date, $end_date, $session->get('traffic_referral_category', null));
      
      ob_start();
      
      $filename = $translator->trans('Traffic_Referrals').'-'.$start_date->format('Y-m-d').'-'.$end_date->format('Y-m-d').'.csv';
      $response = new Response();
      $response->headers->set('Content-Type', 'text/csv');
      $response->headers->set('Content-Disposition', 'attachment; filename="'.$filename.'"');
      
      $response->sendHeaders();
      	
      $output = fopen('php://output', 'w');
      
      fputcsv($output, array($translator->trans('Time'), 
                             $translator->trans('Offer'),
                             $translator->trans('URL'),
                             $translator->trans('Clicks'),
                             $translator->trans('Conversions')
              ));
      
      if($traffic_referrals)
      {
        foreach($traffic_referrals as $traffic_referral)
        {
          fputcsv($output, array($traffic_referral->getStatDateAsString(), $traffic_referral->getOffer(), $traffic_referral->getUrl(), $traffic_referral->getClicks(), $traffic_referral->getConversions()));
        }
      }
      
      fclose($output);

      return $response;
    }
    
    public function signupAnswersAction(Request $request, $mode, $form, $errors, $form_is_posted, $youtube_network_is_selected)
    {
      $signup_question_repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:SignupQuestion');
      $signup_answer_repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:SignupAnswer');
      $translator = $this->get('translator');
      $affiliate_user = $this->getUser();

      if (!$affiliate_user) {
        throw $this->createNotFoundException(
            'No user found'
        );
      }
      
      $affiliate = $affiliate_user->getAffiliate();
      
      //$signup_questions = $signup_question_repository->findAll();
      
      if(!$affiliate->getSignupAnswersRequested())
      {
        $hasoffers = $this->get('hasoffers');
        $signup_question_repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:SignupQuestion');
        $signup_answers_response = $hasoffers->getSignupAnswers($affiliate->getAffiliateId());
        $manager = $this->getDoctrine()->getManager();
        
        if(($signup_answers_response->status == 1) && $signup_answers_response->data)
        {
          $signup_answers_data = (array) $signup_answers_response->data;
                  
          if($signup_answers_data)
          {
            foreach($signup_answers_data as $signup_answer_data)
            {
              $signup_answer_object = $signup_answer_data->SignupAnswer;
                      
              $signup_answer = new SignupAnswer();
              $signup_answer->setAnswerId($signup_answer_object->id);
              $signup_answer->setAnswer($signup_answer_object->answer);
                      
              if($question = $signup_question_repository->findOneByQuestionId($signup_answer_object->question_id))
              {
                $signup_answer->setQuestion($question);  
              } 
                      
              if($affiliate->getAffiliateId() == $signup_answer_object->responder_id)
              {
                $signup_answer->setAffiliate($affiliate);
              } 
                      
              $manager->persist($signup_answer);   
            }
            
            $affiliate->setSignupAnswersRequested(true);  
            
            $manager->flush(); 
          }
        }
      }
      
      $signup_answers = $affiliate->getSignupAnswers();
      
      foreach($signup_answers as $signup_answer)
      {
        $signup_answer->setQuestionTranslated($translator->trans($signup_answer->getQuestion()->getQuestion()));
      }
      
      return $this->render('AnytvDashboardBundle:Profile:signupAnswers.html.twig', array('affiliate'=>$affiliate, 'mode'=>$mode, 'form'=>$form, 'signup_answers'=>$signup_answers, 'errors'=>$errors, 'form_is_posted'=>$form_is_posted, 'youtube_network_is_selected'=>$youtube_network_is_selected));
    }
    
    public function videosAction(Request $request)
    {
      $affiliate_user = $this->getUser();
      $translator = $this->get('translator');
      
      if (!$affiliate_user) {
        throw $this->createNotFoundException(
            'No user found'
        );
      }
      
      $affiliate = $affiliate_user->getAffiliate();
      
      if (!$affiliate) {
        throw $this->createNotFoundException(
            'No affiliate found'
        );
      }
      
      return $this->render('AnytvDashboardBundle:Profile:videos.html.twig', array('title'=>$affiliate, 'affiliate_user'=>$affiliate_user, 'affiliate'=>$affiliate, 'tab'=>'videos'));
    }
    
    public function tabbedVideosComponentAction($affiliate, $affiliate_user)
    {
      return $this->render('AnytvDashboardBundle:Profile:tabbedVideosComponent.html.twig', array('affiliate'=>$affiliate, 'affiliate_user'=>$affiliate_user));
    }
    
    public function topVideosAction(Request $request, $page)
    {
      $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:TrafficReferral');
      $translator = $this->get('translator');
      $session = $this->get('session');
      $affiliate_user = $this->getUser();

      if (!$affiliate_user) {
        throw $this->createNotFoundException(
            'No user found'
        );
      }
      
      $affiliate = $affiliate_user->getAffiliate();
      
      $items_per_page = 10;
      $order_by = 'clicks';
      $order = 'DESC';
        
      $traffic_referrals = $repository->findAllTrafficReferralsFiltered($page, $items_per_page, $order_by, $order, null, null, 'youtube');
      $total_traffic_referrals = $repository->countAllTrafficReferralsFiltered();
      $total_pages = ceil($total_traffic_referrals / $items_per_page);
      
      $offset = ($items_per_page * ($page-1));

      return $this->render('AnytvDashboardBundle:Profile:topVideos.html.twig', array('affiliate'=>$affiliate, 'affiliate_user'=>$affiliate_user, 'traffic_referrals'=>$traffic_referrals, 'total_pages'=>$total_pages, 'page'=>$page, 'offset'=>$offset));
    }
    
    public function videoViewPopupAction()
    {
      return $this->render('AnytvDashboardBundle:Profile:videoViewPopup.html.twig');
    }
    
    public function videoViewAction(Request $request, $id)
    {
      if(!$request->isXmlHttpRequest())
      {
        throw $this->createNotFoundException(
            'Invalid request'
        );
      }
      
      $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:TrafficReferral');
      
      $video = $repository->find($id);

      if (!$video) {
        throw $this->createNotFoundException(
            'No video found for id '.$id
        );
      }
      
      $affiliate_user = $this->getUser();
   
      if (!$affiliate_user) {
        throw $this->createNotFoundException(
            'No user found'
        );
      }
      
      $affiliate = $affiliate_user->getAffiliate();
      
      if (!$affiliate) {
        throw $this->createNotFoundException(
            'No affiliate found'
        );
      }

      $video_id = substr($video->getUrl(), strpos($video->getUrl(), 'youtube.com/watch?v=')+20, 11);
      
      return $this->render('AnytvDashboardBundle:Profile:videoView.html.twig', array('video'=>$video, 'video_id'=>$video_id));
    }
}