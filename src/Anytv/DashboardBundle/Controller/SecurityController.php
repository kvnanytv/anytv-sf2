<?php

namespace Anytv\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

class SecurityController extends Controller
{
    public function loginAction(Request $request, $user_type)
    {
        $offer_repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Offer');
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) 
        {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } 
        else 
        {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }
        
        $featured_offer = null;
        if($featured_offers = $offer_repository->findBy(array('isFeatured'=>1)))
        {
            shuffle($featured_offers);
            $featured_offer = array_pop($featured_offers);
        }
        
        $offer_group = null;
        if($featured_offer)
        {
          if($offer_groups = $featured_offer->getOfferGroups())
          {
            $offer_group = $offer_groups[0];
          }
        }
        
        return $this->render('AnytvDashboardBundle:Security:login.html.twig', array('username' => $session->get(SecurityContext::LAST_USERNAME), 'password'=>'', 'error' => $error, 'user_type'=>$user_type, 'form_action'=>'login_hasoffers', 'featured_offer'=>$featured_offer, 'offer_group'=>$offer_group));
    }
    
    public function loginAfterRegisterAction(Request $request, $user_type, $username, $password)
    {
        $offer_repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Offer');
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) 
        {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } 
        else 
        {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }
        
        $featured_offer = null;
        if($featured_offers = $offer_repository->findBy(array('isFeatured'=>1)))
        {
            shuffle($featured_offers);
            $featured_offer = array_pop($featured_offers);
        }
        
        $offer_group = null;
        if($featured_offer)
        {
          if($offer_groups = $featured_offer->getOfferGroups())
          {
            $offer_group = $offer_groups[0];
          }
        }
        
        return $this->render('AnytvDashboardBundle:Security:loginAfterRegister.html.twig', array('username' => $username, 'password'=>$password, 'error' => $error, 'user_type'=>$user_type, 'featured_offer'=>$featured_offer, 'offer_group'=>$offer_group));
    }
    
    public function loginHasoffersAction(Request $request)
    {
        $session = $request->getSession();
        $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:AffiliateUser');
        $offer_repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Offer');
        $translator = $this->get('translator');
        
        $username = $request->get('_username');
        $password = $request->get('_password');
        $user_type = $request->get('user_type');
        
        $hasoffers = $this->get('hasoffers');
        $auth_results = $hasoffers->authenticateUser($username, $password, $user_type);
        
        $status = $auth_results['status'];
        $httpStatus = $auth_results['httpStatus'];
        $data = $auth_results['data'];
        $errors = $auth_results['errors'];
        $errorMessage = $auth_results['errorMessage'];
        
        $login_passed = false;
        
        if(($status == 1) && ($httpStatus == 200) && !$errors && !$errorMessage)
        {
           $data_user_type = $data->user_type;
           $user_id = $data->user_id;
           $user_status = $data->user_status;
           $account_status = $data->account_status;
           
           if(($data_user_type == $user_type) && $user_id && ($user_status == 'active') && ($account_status == 'active'))
           {
             if(($affiliate_user = $repository->findOneByaffiliateUserId($user_id)) && $affiliate_user->getIsActive())
             {
               $factory = $this->get('security.encoder_factory');
               $manager = $this->getDoctrine()->getManager();
            
               $affiliate_user->setPasswordDecoded($password); 
               $encoder = $factory->getEncoder($affiliate_user);
               $hashed_password = $encoder->encodePassword($password, $affiliate_user->getSalt());
               $affiliate_user->setPassword($hashed_password);
                 
               $affiliate_user->setLastLogin(new \DateTime());
               $affiliate_user->setLoginCount($affiliate_user->getLoginCount() + 1);
               
               if($affiliate_user->getLoginIp() && $request->getClientIp() && ($affiliate_user->getLoginIp() != $request->getClientIp()))
               {
                 $affiliate_user->setLoginIpChangeCount($affiliate_user->getLoginIpChangeCount() + 1);   
               }
                   
               $affiliate_user->setLoginIp($request->getClientIp());
               
               
                 
               $manager->flush();
               
               $login_passed = true;
             }
           }
        }
        
        if(!$login_passed)
        {
          $errorMessage = $errorMessage ? $errorMessage : 'Account is not active.';
          $errorMessage = $translator->trans($errorMessage);
          $this->get('session')->getFlashBag()->add('login_error', $errorMessage);
          return $this->redirect($this->generateUrl('login', array('user_type'=>$user_type)));   
        }
        
        $featured_offer = null;
        if($featured_offers = $offer_repository->findBy(array('isFeatured'=>1)))
        {
            shuffle($featured_offers);
            $featured_offer = array_pop($featured_offers);
        }
        
        $offer_group = null;
        if($featured_offer)
        {
          if($offer_groups = $featured_offer->getOfferGroups())
          {
            $offer_group = $offer_groups[0];
          }
        }
        
        return $this->render('AnytvDashboardBundle:Security:login.html.twig', array('username'=>$username, 'password'=>$password, 'form_action'=>'login_check', 'featured_offer'=>$featured_offer, 'offer_group'=>$offer_group));
    }
}
