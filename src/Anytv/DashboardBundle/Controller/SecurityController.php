<?php

namespace Anytv\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

class SecurityController extends Controller
{
    public function loginAction(Request $request)
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
        
        $featured_offer = $offer_repository->findOneBy(array('isFeatured'=>1));
        
        return $this->render('AnytvDashboardBundle:Security:login.html.twig', array('username' => $session->get(SecurityContext::LAST_USERNAME), 'password'=>'', 'error' => $error, 'form_action'=>'login_hasoffers', 'featured_offer'=>$featured_offer));
    }
    
    public function loginHasoffersAction(Request $request)
    {
        $session = $request->getSession();
        $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:AffiliateUser');
        $offer_repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Offer');
        
        $username = $request->get('_username');
        $password = $request->get('_password');
        
        $hasoffers = $this->get('hasoffers');
        $db_user_type = 'affiliate_user';
        $auth_results = $hasoffers->authenticateUser($username, $password, $db_user_type);
        
        $status = $auth_results['status'];
        $httpStatus = $auth_results['httpStatus'];
        $data = $auth_results['data'];
        $errors = $auth_results['errors'];
        $errorMessage = $auth_results['errorMessage'];
        
        $form_action = 'login_hasoffers';
        
        if(($status == 1) && ($httpStatus == 200) && !$errors && !$errorMessage)
        {
           $user_type = $data->user_type;
           $user_id = $data->user_id;
           $user_status = $data->user_status;
           $account_status = $data->account_status;
           
           if(($user_type == $db_user_type) && $user_id && ($user_status == 'active') && ($account_status == 'active'))
           {
             if($affiliate_user = $repository->findOneByaffiliateUserId($user_id))
             {
               //$affiliate_user_password = $affiliate_user->getPassword();
               
               //if(!$affiliate_user_password)
               //{
                 $factory = $this->get('security.encoder_factory');
                 $manager = $this->getDoctrine()->getManager();
            
                 $affiliate_user->setPasswordDecoded($password); 
                 $encoder = $factory->getEncoder($affiliate_user);
                 $hashed_password = $encoder->encodePassword($password, $affiliate_user->getSalt());
                 $affiliate_user->setPassword($hashed_password);
                 
                 $affiliate_user->setLastLogin(new \DateTime());
                 
                 $manager->flush();
               //}
               
               $form_action = 'login_check';    
             }
           }
           
           
        }
        
        $featured_offer = $offer_repository->findOneBy(array('isFeatured'=>1));
        
        
        return $this->render('AnytvDashboardBundle:Security:login.html.twig', array('username'=>$username, 'password'=>$password, 'error'=>$errorMessage, 'form_action'=>$form_action, 'featured_offer'=>$featured_offer));
    }
}
