<?php

namespace Anytv\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Anytv\DashboardBundle\Entity\Affiliate;
use Anytv\DashboardBundle\Entity\AffiliateUser;
use Anytv\DashboardBundle\Form\Type\AffiliateType;

class AffiliateController extends Controller
{
    public function indexAction(Request $request, $page)
    {
        $user = $this->getUser();
        
        $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Affiliate');
        $country_repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Country');
        $session = $this->get('session');
        $translator = $this->get('translator');
        $max_affiliate_id = $repository->getMaxAffiliateId();
        
        $countries_choices = array();
        $countries = $country_repository->findAll();
        foreach($countries as $country)
        {
          $countries_choices[$country->getId()] = $country->getName();  
        }
        
        $form = $this->createFormBuilder(array('affiliate_keyword'=>$session->get('affiliate_keyword'), 'affiliate_country'=>$session->get('affiliate_country'), 'affiliate_paypal'=>$session->get('affiliate_paypal', false), 'affiliate_status'=>$session->get('affiliate_status', 'active')))
        ->add('affiliate_keyword', 'text', array('required'=>false))
        ->add('affiliate_country', 'choice', array('required' => false, 'choices' => $countries_choices, 'empty_value' => '', 'label'=>$translator->trans('Country')))
        ->add('affiliate_paypal', 'checkbox', array('label'=>$translator->trans('Paypal Email'), 'required'=>false))
        ->add('affiliate_status', 'choice', array('required' => true, 'choices' => array('active'=>'active', 'pending'=>'pending', 'deleted'=>'deleted', 'blocked'=>'blocked', 'rejected'=>'rejected'), 'label'=>$translator->trans('Status')))
        ->add('affiliate_search', 'submit', array('label'=>' '))
        //->add('affiliate_update', 'submit', array('label'=>$translator->trans('update')))
        //->add('affiliate_update_paypal', 'submit', array('label'=>$translator->trans('update paypal')))
        //->add('affiliate_update_referrer', 'submit', array('label'=>$translator->trans('update referrer')))
        ->getForm();
        
        $form->handleRequest($request);
        
        if($form->isValid()) 
        {
          if($form->get('affiliate_search')->isClicked())
          {
            $data = $form->getData();
            $session->set('affiliate_keyword', $data['affiliate_keyword']);
            $session->set('affiliate_country', $data['affiliate_country']);
            $session->set('affiliate_paypal', $data['affiliate_paypal']);
            $session->set('affiliate_status', $data['affiliate_status']);
          }
          elseif($form->get('affiliate_update_paypal')->isClicked())
          {
            $manager = $this->getDoctrine()->getManager();
            $hasoffers = $this->get('hasoffers');
            $paypal_email_count = 0;
            $paypal_request_batch = 100;
            
            $affiliates_wo_paypal_email = $repository->findBy(array('status'=>'active', 'paypalEmailRequested'=>false), null, $paypal_request_batch);
            
            if($affiliates_wo_paypal_email)
            {
              foreach($affiliates_wo_paypal_email as $affiliate)
              {
                if($paypal_email = $hasoffers->getPaypalEmail($affiliate->getAffiliateId()))
                {
                  $affiliate->setPaypalEmail($paypal_email);
                  $paypal_email_count++;
                }
                
                $affiliate->setPaypalEmailRequested(true);   
              }
            
              $manager->flush();
            
              $session->getFlashBag()->add('flash_message', $paypal_email_count.'/'.$paypal_request_batch.' paypal emails set.');  
            }
            else
            {
              $session->getFlashBag()->add('flash_message', 'All paypal emails are set.');  
            }
            
            return $this->redirect($this->generateUrl('affiliates'));  
          }
          elseif($form->get('affiliate_update_referrer')->isClicked())
          {
            $manager = $this->getDoctrine()->getManager();
            
            $referrer_count = 0;
            $referrer_request_batch = 500;
            
            $affiliates_wo_referrers = $repository->findBy(array('referrerRequested'=>false), null, $referrer_request_batch);
            
            if($affiliates_wo_referrers)
            {
              foreach($affiliates_wo_referrers as $affiliate)
              {
                if($affiliate->getReferralId() && ($referrer = $repository->findOneBy(array('affiliateId'=>$affiliate->getReferralId()))))
                {
                  $affiliate->setReferrer($referrer);
                  $referrer_count++;
                }
                
                $affiliate->setReferrerRequested(true);   
              }
            
              $manager->flush();
            
              $session->getFlashBag()->add('flash_message', $referrer_count.'/'.$referrer_request_batch.' referrers set.');  
            }
            else
            {
              $session->getFlashBag()->add('flash_message', 'All referrers are set.');  
            }
            
            return $this->redirect($this->generateUrl('affiliates'));  
          }
          else
          {
            $affiliate_user_repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:AffiliateUser');
            $factory = $this->get('security.encoder_factory');
            $manager = $this->getDoctrine()->getManager();
          
            $hasoffers = $this->get('hasoffers');
            $affiliates_data = $hasoffers->getAffiliates($max_affiliate_id);
            
            foreach($affiliates_data as $affiliate_data)
            {
              $affiliate_object = $affiliate_data->Affiliate;
              $affiliate_users_object = $affiliate_data->AffiliateUser;
              
              $affiliate = $repository->findOneBy(array('affiliateId'=>$affiliate_object->id));
              
              if($affiliate)
              {
                $affiliate->setCompany($affiliate_object->company);
                $affiliate->setAddress1($affiliate_object->address1);
                $affiliate->setAddress2($affiliate_object->address2);
                $affiliate->setCity($affiliate_object->city);
                //$affiliate->setRegion($affiliate_object->region);
                
                if($country = $country_repository->findOneByCode($affiliate_object->country))
                {
                  $affiliate->setCountry($country); 
                } 
          
                $affiliate->setOther($affiliate_object->other);
                $affiliate->setZipcode($affiliate_object->zipcode);
                $affiliate->setPhone($affiliate_object->phone);
                $affiliate->setFax($affiliate_object->fax);
                $affiliate->setSignupIp($affiliate_object->signup_ip);
                $affiliate->setDateAdded(new \DateTime($affiliate_object->date_added));
                $affiliate->setStatus($affiliate_object->status);
                $affiliate->setWantsAlerts($affiliate_object->wants_alerts);
                $affiliate->setPaymentMethod($affiliate_object->payment_method);
                $affiliate->setPaymentTerms($affiliate_object->payment_terms);
                
                
                //@todo set the referrer on update
                $affiliate->setReferralId($affiliate_object->referral_id);
                
                if($affiliate_object->referral_id && ($referrer = $repository->findOneBy(array('affiliateId'=>$affiliate_object->referral_id))))
                {
                  $affiliate->setReferrer($referrer);
                }
                $affiliate->setReferrerRequested(true);
                
                $affiliate->setAffiliateTierId($affiliate_object->affiliate_tier_id); 
                
                foreach($affiliate_users_object as $affiliate_user_object)
                {
                  $affiliate_user = $affiliate_user_repository->findOneBy(array('affiliateUserId'=>$affiliate_user_object->id));
                  
                  if($affiliate_user)
                  {
                    $affiliate_user->setEmail($affiliate_user_object->email);
                    $affiliate_user->setTitle($affiliate_user_object->title);
                    $affiliate_user->setFirstName($affiliate_user_object->first_name);
                    $affiliate_user->setLastName($affiliate_user_object->last_name);
                    $affiliate_user->setPhone($affiliate_user_object->phone);
                    $affiliate_user->setCellPhone($affiliate_user_object->cell_phone);
                    $affiliate_user->setStatus($affiliate_user_object->status);
                    $affiliate_user->setIsCreator($affiliate_user_object->is_creator);
                    $affiliate_user->setJoinDate(new \DateTime($affiliate_user_object->join_date));
                    $affiliate_user->setModified(new \DateTime($affiliate_user_object->modified));
                    $affiliate_user->setLastLogin(new \DateTime($affiliate_user_object->last_login));
                    $affiliate_user->setWantsAlerts($affiliate_user_object->wants_alerts);
          
                    $affiliate_user->setAffiliate($affiliate); 
                    
                    if($affiliate_object->status != 'active')
                    {
                      $affiliate_user->setIsActive(false);    
                    }
                  }
                  else
                  {
                    $affiliate_user = new AffiliateUser(); 
                    $affiliate_user->setAffiliateUserId($affiliate_user_object->id);
                    $affiliate_user->setEmail($affiliate_user_object->email);
                    
                    //$encoder = $factory->getEncoder($affiliate_user);
                    //$password = $encoder->encodePassword('dashboard', $affiliate_user->getSalt());
                    //$affiliate_user->setPassword($password);
                    
                    $affiliate_user->setTitle($affiliate_user_object->title);
                    $affiliate_user->setFirstName($affiliate_user_object->first_name);
                    $affiliate_user->setLastName($affiliate_user_object->last_name);
                    $affiliate_user->setPhone($affiliate_user_object->phone);
                    $affiliate_user->setCellPhone($affiliate_user_object->cell_phone);
                    $affiliate_user->setStatus($affiliate_user_object->status);
                    $affiliate_user->setIsCreator($affiliate_user_object->is_creator);
                    $affiliate_user->setJoinDate(new \DateTime($affiliate_user_object->join_date));
                    $affiliate_user->setModified(new \DateTime($affiliate_user_object->modified));
                    $affiliate_user->setLastLogin(new \DateTime($affiliate_user_object->last_login));
                    $affiliate_user->setWantsAlerts($affiliate_user_object->wants_alerts);
          
                    $affiliate_user->setAffiliate($affiliate);
                    
                    if($affiliate_object->status != 'active')
                    {
                      $affiliate_user->setIsActive(false);    
                    }
             
                    $manager->persist($affiliate_user);    
                  }
                }
              }
              else
              {
                $affiliate = new Affiliate();
                $affiliate->setAffiliateId($affiliate_object->id);
                $affiliate->setCompany($affiliate_object->company);
                $affiliate->setAddress1($affiliate_object->address1);
                $affiliate->setAddress2($affiliate_object->address2);
                $affiliate->setCity($affiliate_object->city);
                //$affiliate->setRegion($affiliate_object->region);
          
                if($country = $country_repository->findOneByCode($affiliate_object->country))
                {
                  $affiliate->setCountry($country); 
                } 
          
                $affiliate->setOther($affiliate_object->other);
                $affiliate->setZipcode($affiliate_object->zipcode);
                $affiliate->setPhone($affiliate_object->phone);
                $affiliate->setFax($affiliate_object->fax);
                $affiliate->setSignupIp($affiliate_object->signup_ip);
                $affiliate->setDateAdded(new \DateTime($affiliate_object->date_added));
                $affiliate->setStatus($affiliate_object->status);
                $affiliate->setWantsAlerts($affiliate_object->wants_alerts);
                $affiliate->setPaymentMethod($affiliate_object->payment_method);
                $affiliate->setPaymentTerms($affiliate_object->payment_terms);
               
                $affiliate->setReferralId($affiliate_object->referral_id);
                $affiliate->setAffiliateTierId($affiliate_object->affiliate_tier_id);
          
                $manager->persist($affiliate);   
                
                foreach($affiliate_users_object as $affiliate_user_object)
                {
                  $affiliate_user = $affiliate_user_repository->findOneBy(array('affiliateUserId'=>$affiliate_user_object->id));
                  
                  if($affiliate_user)
                  {
                    $affiliate_user->setEmail($affiliate_user_object->email);
                    $affiliate_user->setTitle($affiliate_user_object->title);
                    $affiliate_user->setFirstName($affiliate_user_object->first_name);
                    $affiliate_user->setLastName($affiliate_user_object->last_name);
                    $affiliate_user->setPhone($affiliate_user_object->phone);
                    $affiliate_user->setCellPhone($affiliate_user_object->cell_phone);
                    $affiliate_user->setStatus($affiliate_user_object->status);
                    $affiliate_user->setIsCreator($affiliate_user_object->is_creator);
                    $affiliate_user->setJoinDate(new \DateTime($affiliate_user_object->join_date));
                    $affiliate_user->setModified(new \DateTime($affiliate_user_object->modified));
                    $affiliate_user->setLastLogin(new \DateTime($affiliate_user_object->last_login));
                    $affiliate_user->setWantsAlerts($affiliate_user_object->wants_alerts);
          
                    $affiliate_user->setAffiliate($affiliate);
                    
                    if($affiliate_object->status != 'active')
                    {
                      $affiliate_user->setIsActive(false);    
                    }
                  }
                  else
                  {
                    $affiliate_user = new AffiliateUser(); 
                    $affiliate_user->setAffiliateUserId($affiliate_user_object->id);
                    $affiliate_user->setEmail($affiliate_user_object->email);
                    
                    //$encoder = $factory->getEncoder($affiliate_user);
                    //$password = $encoder->encodePassword('dashboard', $affiliate_user->getSalt());
                    //$affiliate_user->setPassword($password);
                    
                    $affiliate_user->setTitle($affiliate_user_object->title);
                    $affiliate_user->setFirstName($affiliate_user_object->first_name);
                    $affiliate_user->setLastName($affiliate_user_object->last_name);
                    $affiliate_user->setPhone($affiliate_user_object->phone);
                    $affiliate_user->setCellPhone($affiliate_user_object->cell_phone);
                    $affiliate_user->setStatus($affiliate_user_object->status);
                    $affiliate_user->setIsCreator($affiliate_user_object->is_creator);
                    $affiliate_user->setJoinDate(new \DateTime($affiliate_user_object->join_date));
                    $affiliate_user->setModified(new \DateTime($affiliate_user_object->modified));
                    $affiliate_user->setLastLogin(new \DateTime($affiliate_user_object->last_login));
                    $affiliate_user->setWantsAlerts($affiliate_user_object->wants_alerts);
          
                    $affiliate_user->setAffiliate($affiliate); 
                    
                    if($affiliate_object->status != 'active')
                    {
                      $affiliate_user->setIsActive(false);    
                    }
             
                    $manager->persist($affiliate_user);    
                  }
                }
              }
            }
            
            $manager->flush();
          
            return $this->redirect($this->generateUrl('affiliates_reset'));
          }
          
          
        }
        
        $items_per_page = 30;
        $order_by = 'dateAdded';
        $order = 'DESC';
        
        $affiliates = $repository->findAllAffiliates($page, $items_per_page, $order_by, $order, $session->get('affiliate_keyword', null), $session->get('affiliate_country', null), $session->get('affiliate_status', 'active'), $session->get('affiliate_paypal', false));
        $total_affiliates = $repository->countAllAffiliates($session->get('affiliate_keyword', null), $session->get('affiliate_country', null), $session->get('affiliate_status', 'active'), $session->get('affiliate_paypal', false));
        $total_pages = ceil($total_affiliates / $items_per_page);
        
        return $this->render('AnytvDashboardBundle:Affiliate:index.html.twig', array('title'=>$translator->trans('Affiliates'), 'affiliates'=>$affiliates, 'total_affiliates'=>$total_affiliates, 'page'=>$page, 'total_pages'=>$total_pages, 'form'=>$form->createView(), 'max_affiliate_id'=>$max_affiliate_id));
    }
    
    public function resetAction()
    {
        $session = $this->get('session');
        $session->set('affiliate_keyword', null);
        $session->set('affiliate_country', null);
        $session->set('affiliate_paypal', false);
        $session->set('affiliate_status', 'active');
        
        return $this->redirect($this->generateUrl('affiliates'));
    }
    
    public function editAction(Request $request, $id)
    {
      $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Affiliate');
      
      $affiliate = $repository->find($id);

      if (!$affiliate) {
        throw $this->createNotFoundException(
            'No affiliate found for id '.$id
        );
      }

      $form = $this->createForm(new AffiliateType(), $affiliate);

      $form->handleRequest($request);

      if ($form->isValid()) {
        
        $affiliate = $form->getData();
        
        $em = $this->getDoctrine()->getManager();
        
        $em->persist($affiliate);
        $em->flush();

        return $this->redirect($this->generateUrl('affiliate_view', array('id'=>$affiliate->getId())));
      }

      return $this->render('AnytvDashboardBundle:Affiliate:edit.html.twig', array('title'=>'Edit '.$affiliate, 'form'=>$form->createView(), 'affiliate'=>$affiliate));
    }
    
    public function viewAction($id)
    {
      $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Affiliate');
      $traffic_referral_repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:TrafficReferral');
      $translator = $this->get('translator');
      
      $affiliate = $repository->find($id);

      if (!$affiliate) {
        throw $this->createNotFoundException(
            'No affiliate found for id '.$id
        );
      }
      
      $affiliate_users = $affiliate->getAffiliateUsers();
      //$traffic_referrals = $affiliate->getTrafficReferrals();
      $traffic_referrals = $traffic_referral_repository->findTrafficReferralsByAffiliate($affiliate);
      $referred_affiliates = $affiliate->getReferredAffiliates();
      
      $title = $affiliate->getCompany() ? $affiliate->getCompany() : '---';

      return $this->render('AnytvDashboardBundle:Affiliate:view.html.twig', array('title'=>$title, 'affiliate'=>$affiliate, 'affiliate_status'=>$translator->trans($affiliate->getStatus()), 'affiliate_users'=>$affiliate_users, 'traffic_referrals'=>$traffic_referrals, 'referred_affiliates'=>$referred_affiliates));
    }
    
    public function listByCountryAction($country_id, $status, $page)
    { 
      $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Affiliate');
      $country_repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Country');
      
      $items_per_page = 10;
      $order_by = 'company';
      $order = 'ASC';
      $country = $country_repository->find($country_id);
        
      $affiliates = $repository->findAllAffiliatesByCountry($page, $items_per_page, $order_by, $order, $country, $status);
      $total_affiliates = $repository->countAllAffiliatesByCountry($country, $status);
      $total_pages = ceil($total_affiliates / $items_per_page);
      
      return $this->render('AnytvDashboardBundle:Affiliate:listByCountry.html.twig', array('affiliates'=>$affiliates, 'status'=>$status, 'total_affiliates'=>$total_affiliates, 'page'=>$page, 'total_pages'=>$total_pages, 'country_id'=>$country_id, 'status'=>$status));
    }
    
}
