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

class ProfileController extends Controller
{
    public function viewAction(Request $request, $tab, $mode)
    {
      $affiliate_user = $this->getUser();
      $translator = $this->get('translator');
      $em = $this->getDoctrine()->getManager();
      
   
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
        $hasoffers = $this->get('hasoffers');
        
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
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            
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
            
            $hasoffers = $this->get('hasoffers');
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
            
            $hasoffers = $this->get('hasoffers');
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
              $hasoffers = $this->get('hasoffers');
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
        }
        
        $form_view = $form->createView();
      }

      return $this->render('AnytvDashboardBundle:Profile:view.html.twig', array('title'=>$affiliate, 'affiliate_user'=>$affiliate_user, 'affiliate'=>$affiliate, 'affiliate_user_status'=>$translator->trans($affiliate_user->getStatus()), 'affiliate_status'=>$translator->trans($affiliate->getStatus()), 'tab'=>$tab, 'mode'=>$mode, 'form'=>$form_view, 'errors'=>$errors));
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
      return $this->render('AnytvDashboardBundle:Profile:idCard.html.twig', array('affiliate'=>$affiliate, 'affiliate_user'=>$affiliate_user, 'page'=>$page));
    }
    
    public function tabbedComponentAction($affiliate, $affiliate_user)
    {
      return $this->render('AnytvDashboardBundle:Profile:tabbedComponent.html.twig', array('affiliate'=>$affiliate, 'affiliate_user'=>$affiliate_user));
    }
    
    public function tabbedProfileComponentAction($tab, $mode, $form, $errors)
    {
      return $this->render('AnytvDashboardBundle:Profile:tabbedProfileComponent.html.twig', array('tab'=>$tab, 'mode'=>$mode, 'form'=>$form, 'errors'=>$errors));
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
      
      $form = $this->createFormBuilder(array('referral_hide_zeros'=>$session->get('referral_hide_zeros', false), 'referral_start_date'=>$session->get('referral_start_date', new \DateTime(date('Y-m-d', strtotime('2013-02-11')))), 'referral_end_date'=>$session->get('referral_end_date', new \DateTime(date('Y-m-d')))))
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
      }
      
      $items_per_page = 10;
      $order_by = 'id';
      $order = 'DESC';
        
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

      return $this->render('AnytvDashboardBundle:Profile:myReferrals.html.twig', array('affiliate'=>$affiliate, 'affiliate_user'=>$affiliate_user, 'referrals'=>$referrals, 'total_pages'=>$total_pages, 'page'=>$page, 'form'=>$form->createView(), 'commission_rate_percent'=>$commission_rate_percent));
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
      $order_by = 'company';
      $order = 'ASC';
      
      $referred_affiliates = $repository->findAllAffiliatesByReferrer($affiliate, $page, $items_per_page, $order_by, $order);
      $total_referred_affiliates = $repository->countAllAffiliatesByReferrer($affiliate);
      $total_pages = ceil($total_referred_affiliates / $items_per_page);

      return $this->render('AnytvDashboardBundle:Profile:myReferralList.html.twig', array('affiliate'=>$affiliate, 'affiliate_user'=>$affiliate_user, 'referred_affiliates'=>$referred_affiliates, 'total_pages'=>$total_pages, 'page'=>$page));
    }
    
    public function myConversionsAction(Request $request, $page)
    {
      $conversion_repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Conversion');
      $affiliate_user = $this->getUser();

      if (!$affiliate_user) {
        throw $this->createNotFoundException(
            'No user found'
        );
      }
      
      $affiliate = $affiliate_user->getAffiliate();
      
      /*
      $conversions = array();
      
      $hasoffers = $this->get('hasoffers');
      $conversions_response = $hasoffers->getAffiliateConversions($affiliate->getAffiliateId(), $page);
      $total_pages = $conversions_response->pageCount;
      $conversions_data = $conversions_response->data;
      
      foreach($conversions_data as $conversion_data)
      {
        $conversion_object = $conversion_data->Stat;
            
        $conversion = array();
        $conversion['ip'] = $conversion_object->ip;
        $conversion['ad_id'] = $conversion_object->ad_id;
        $conversion['status'] = $conversion_object->status;
        $conversion['payout'] = number_format($conversion_object->payout, 2);
        $conversion['date'] = date_format(new \DateTime($conversion_object->datetime), 'Y-m-d');
              
        if($offer = $offer_repository->findOneBy(array('offerId'=>$conversion_object->offer_id)))
        {
          $conversion['offer'] = $offer;    
        }
        else
        {
          $conversion['offer'] = null;
        }
              
        $conversions[] = $conversion; 
      }
      */
      
      //$conversions = $affiliate->getConversions();
      
      $items_per_page = 10;
      $order_by = 'createdAt';
      $order = 'DESC';
        
      $conversions = $conversion_repository->findAllConversions($page, $items_per_page, $order_by, $order, $affiliate);
      $total_conversions = $conversion_repository->countAllConversions($affiliate);
      $total_pages = ceil($total_conversions / $items_per_page);

      return $this->render('AnytvDashboardBundle:Profile:myConversions.html.twig', array('affiliate'=>$affiliate, 'affiliate_user'=>$affiliate_user, 'conversions'=>$conversions, 'total_pages'=>$total_pages, 'page'=>$page));
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
}