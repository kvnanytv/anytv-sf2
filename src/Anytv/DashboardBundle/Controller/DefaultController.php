<?php

namespace Anytv\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Anytv\DashboardBundle\Entity\Affiliate;
use Anytv\DashboardBundle\Entity\AffiliateUser;

class DefaultController extends Controller
{
    //public function indexAction($_controller, $_format, $_locale, $_route)
    public function indexAction()
    {
        $affiliate_user = $this->getUser();
        $translator = $this->get('translator');
      
        if (!$affiliate_user) {
          throw $this->createNotFoundException(
            'No user found'
          );
        }
      
        $affiliate = $affiliate_user->getAffiliate();
        
        return $this->render('AnytvDashboardBundle:Default:index.html.twig', array('title'=>$translator->trans('Any.TV Dashboard'), 'affiliate_user'=>$affiliate_user, 'affiliate'=>$affiliate));
    }
    
    public function justNotesAction(Request $request)
    {
        $request = null;
        
        //redirect - 302 (temporary) redirect
        return $this->redirect($this->generateUrl('homepage'));
        
        //redirect - 301 (permanent) redirect
        return $this->redirect($this->generateUrl('homepage'), 301);
        
        //Absolute URLs
        // set 3rd parameter to true
        // 
        // for CLI 
        $this->get('router')->getContext()->setHost('www.example.com');
        
        //forward
        return $this->forward('AnytvDashboardBundle:Default2:index', array(
          'name'  => 'Dennis',
          'color' => 'green',
        ));
        $httpKernel = $this->container->get('http_kernel');
        return $httpKernel->forward('AnytvDashboardBundle:Default2:index', array(
        'name'  => 'Dennis',
        'color' => 'green',
        ));

        //template
        return $this->render('AnytvDashboardBundle:Default2:index.html.twig', array());
        //or
        $content = $this->renderView('AnytvDashboardBundle:Default2:index.html.twig', array('name' => 'Dennis'));
        return new Response($content);
        //or
        $templating = $this->get('templating');
        $content = $templating->render('AnytvDashboardBundle:Default2:index.html.twig', array('name' => 'Dennis'));
        return new Response($content);
        
        //services
        $request = $this->getRequest();
        $templating = $this->get('templating');
        $router = $this->get('router');
        $mailer = $this->get('mailer');
        
        //404
        $product = null;
        if (!$product) {
          throw $this->createNotFoundException('The product does not exist');
        }
        
        //500
        throw new \Exception('Something went wrong!');
        
        //Session
        $session = $this->getRequest()->getSession();
        $session->set('foo', 'bar');
        $foo = $session->get('foo', null);
        
        //Flash
        $this->get('session')->getFlashBag()->add('notice', 'Your changes were saved!');
        
        //Response
        $response = new Response('Hello there', 200); //defaults to 200
        // create a JSON-response with a 200 status code
        // http://symfony.com/doc/current/components/http_foundation/introduction.html#component-http-foundation-json-response
        $response = new Response(json_encode(array('name' => 'Dennis')));
        $response->headers->set('Content-Type', 'application/json');
        // The header names are normalized so that using Content-Type is equivalent to content-type or even content_type.
        //Files
        // http://symfony.com/doc/current/components/http_foundation/introduction.html#component-http-foundation-serving-files
        
        //Request
        $request = $this->getRequest();
        $request->isXmlHttpRequest(); // is it an Ajax request?
        $request->getPreferredLanguage(array('en', 'fr'));
        $request->query->get('page'); // get a $_GET parameter
        $request->request->get('page'); // get a $_POST parameter
        
        
        
        return $this->render('AnytvDashboardBundle:Default2:index.html.twig', array());
    }
    
    public function termsAction(Request $request)
    {
        $translator = $this->get('translator');
        
        return $this->render('AnytvDashboardBundle:Default:terms.html.twig', array('title'=>$translator->trans('Terms & Conditions')));
    }
    
    public function privacyPolicyAction(Request $request)
    {
        $translator = $this->get('translator');
        
        return $this->render('AnytvDashboardBundle:Default:privacyPolicy.html.twig', array('title'=>$translator->trans('Privacy Policy')));
    }
    
    public function forgotPasswordAction(Request $request)
    {
        $affiliate_user_repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:AffiliateUser');
        $translator = $this->get('translator');
        
        $form = $this->createFormBuilder()    
          ->add('email', 'email', array('label'=>$translator->trans('Email: *')))
          ->add('lookup', 'submit', array('label'=>$translator->trans('Lookup Account')))
          ->getForm();

        $form->handleRequest($request);
        
        $errors = array();
        $password_reset = false;
        
        if ($form->isValid()) {
          
          $data = $form->getData();
          
          $email = $data['email'];
          
          $affiliate_user = $affiliate_user_repository->findOneBy(array('email'=>$email));
          
          if(!$affiliate_user)
          {
            $errors[] = $translator->trans('No user account was found for the address given.');
          }
          else
          {
            $hasoffers = $this->get('hasoffers');
            $reset_password_result = $hasoffers->resetPassword($affiliate_user->getAffiliateUserId()); 
            
            if(($reset_password_result->status == 1) && $reset_password_result->data)
            {
              $update_password_result = $hasoffers->updateAffiliateUserField($affiliate_user->getAffiliateUserId(), 'password', trim($reset_password_result->data), false); 
              
              if(($update_password_result->status == 1) && $update_password_result->data)
              {
                $password_reset = true; 
              
                $manager = $this->getDoctrine()->getManager();
              
                $affiliate_user->setLastChangePassword(new \DateTime());
                $affiliate_user->setForgotPasswordRequestCount($affiliate_user->getForgotPasswordRequestCount() + 1);
               
                $manager->flush();
                
                $dashboard_url = $this->generateUrl('anytv_dashboard_homepage', array(), true);
              
                $message = \Swift_Message::newInstance()
                  ->setContentType('text/html')
                  ->setSubject($translator->trans('Recover Lost Password‏'))
                  ->setFrom('support@any.tv', 'any.TV')
                  ->setTo($email)
                  ->setBody($this->renderView('AnytvDashboardBundle:Default:forgotPasswordEmail.html.twig', array('affiliate_user' => $affiliate_user, 'new_password'=>$reset_password_result->data, 'dashboard_url'=>$dashboard_url)));
            
                $this->get('mailer')->send($message);    
              }
              else
              {
                //$errors[] = $translator->trans(json_decode($reset_password_result->errors));
                $errors[] = $translator->trans('An error has occurred, please try again.');    
              }
            }
            else
            {
              //$errors[] = $translator->trans(json_decode($reset_password_result->errors));
              $errors[] = $translator->trans('An error has occurred, please try again.');
            }
          }
          
        }
        
        return $this->render('AnytvDashboardBundle:Default:forgotPassword.html.twig', array('title'=>$translator->trans('Recover Lost Password '), 'form'=>$form->createView(), 'errors'=>$errors, 'password_reset'=>$password_reset));
    }
    
    public function signupAction(Request $request, $id)
    {
        if ($this->getUser()) 
        {
          return $this->redirect($this->generateUrl('anytv_dashboard_homepage'));  
        }
        
        $country_repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Country');
        $affiliate_user_repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:AffiliateUser');
        $translator = $this->get('translator');
        
        $countries_choices = array();
        $countries = $country_repository->findAll();
        foreach($countries as $country)
        {
          $countries_choices[$country->getCode()] = $country->getName();  
        }
        $countries_choices['other'] = $translator->trans('Not Listed');
        
        $defaultData = array('country' => 'HK');
        
        $form = $this->createFormBuilder($defaultData)    
          ->add('company', 'text', array('label'=>$translator->trans('Company / Name: *')))
          ->add('address1', 'text', array('label'=>$translator->trans('Address 1: *')))
          ->add('address2', 'text', array('label'=>$translator->trans('Address 2:'), 'required'=>false))
          ->add('city', 'text', array('label'=>$translator->trans('City: *')))
          ->add('country', 'choice', array('choices' => $countries_choices, 'empty_value' => '', 'label'=>$translator->trans('Country: *')))
          ->add('country_other', 'text', array('label'=>$translator->trans('Country (other): *'), 'required'=>false))
          ->add('zipcode', 'text', array('label'=>$translator->trans('Zipcode: *')))
          ->add('phone', 'text', array('label'=>$translator->trans('Phone: *')))
          ->add('email', 'email', array('label'=>$translator->trans('Email: *')))
          ->add('password', 'password', array('label'=>$translator->trans('Password: *')))
          ->add('confirm_password', 'password', array('label'=>$translator->trans('Confirm Password: *')))
          ->add('first_name', 'text', array('label'=>$translator->trans('First name: *')))
          ->add('last_name', 'text', array('label'=>$translator->trans('Last name: *')))
          ->add('title', 'text', array('label'=>$translator->trans('Title:'), 'required'=>false))
          ->add('terms', 'checkbox')
          ->add('signup', 'submit', array('label'=>$translator->trans('CREATE AN ACCOUNT')))
          ->getForm();

        $form->handleRequest($request);

        $errors = array();
        $country_is_listed = true;
        
        if ($form->isValid()) {
          
          $data = $form->getData();
          
          $company = $data['company'];
          
          if($company == '')
          {
            $errors[] = $translator->trans('Company / Name is required.');    
          }
          
          $address1 = $data['address1'];
          
          if($address1 == '')
          {
            $errors[] = $translator->trans('Address 1 is required.');    
          }
          
          $address2 = $data['address2'];
          
          $city = $data['city'];
          
          if($city == '')
          {
            $errors[] = $translator->trans('City is required.');    
          }
          
          $country = $data['country'];
          $country_other = $data['country_other'];
          
          if(($country == 'other') && ($country_other == ''))
          {
            $errors[] = $translator->trans('Country is required.');   
          }
          
          if($country == 'other')
          {  
            $country_is_listed = false;
          }
          
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
          
          $zipcode = $data['zipcode'];
          
          if($zipcode == '')
          {
            $errors[] = $translator->trans('Zipcode is required.');    
          }
          
          $phone = $data['phone'];
          
          if($phone == '')
          {
            $errors[] = $translator->trans('Phone is required.');    
          }
          
          $first_name = $data['first_name'];
          
          if($first_name == '')
          {
            $errors[] = $translator->trans('First Name is required.');    
          }
          
          $last_name = $data['last_name'];
          
          if($last_name == '')
          {
            $errors[] = $translator->trans('Last Name is required.');    
          }
          
          $title = $data['title'];
          
          $email = $data['email'];
          
          $affiliate_user = $affiliate_user_repository->findOneBy(array('email'=>$email));
          
          if($affiliate_user)
          {
            $errors[] = $translator->trans('E-mail Address already exists.');
          }
          
          $password = $data['password'];
          $confirm_password = $data['confirm_password'];
          
          if($password != $confirm_password)
          {
            $errors[] = $translator->trans('Passwords do not match.');    
          }
          
          if(!$errors)
          {
             $affiliate_data = array('company'=>$company,
                                     'address1'=>$address1,
                                     'address2'=>$address2,
                                     'city'=>$city,
                                     'country'=>$country,
                                     'region'=>$region,
                                     'other'=>$country_other,
                                     'zipcode'=>$zipcode,
                                     'phone'=>$phone,
                                     'signup_ip'=>$request->getClientIp(),
                                     'referral_id'=>$id
                                     );
             
             $affiliate_user_data = array('email' => $email,
		                          'first_name' => $first_name,
		                          'last_name' => $last_name,
		                          'title' => $title,
		                          'password' => $password,
                                          'password_confirmation' => $password
                                          );
             
             $hasoffers = $this->get('hasoffers');
             $signup_response = $hasoffers->signup($affiliate_data, $affiliate_user_data);
             
             $status = $signup_response['status'];
             $data = $signup_response['data'];
             $hasoffer_errors = $signup_response['errors'];
             
             if(($status == 1) && !$hasoffer_errors)
             {
               $manager = $this->getDoctrine()->getManager();
               
               $affiliate_user_object = $data->AffiliateUser;
               $affiliate_object = $data->Affiliate;
              
               $affiliate = new Affiliate();
               $affiliate->setAffiliateId($affiliate_object->id);
               $affiliate->setCompany($affiliate_object->company);
               $affiliate->setAddress1($affiliate_object->address1);
               $affiliate->setAddress2($affiliate_object->address2);
               $affiliate->setCity($affiliate_object->city);
               
               if($country = $country_repository->findOneByCode($affiliate_object->country))
               {
                 $affiliate->setCountry($country); 
               } 
          
               $affiliate->setOther($affiliate_object->other);
               $affiliate->setZipcode($affiliate_object->zipcode);
               $affiliate->setPhone($affiliate_object->phone);
               $affiliate->setSignupIp($affiliate_object->signup_ip);
               $affiliate->setDateAdded(new \DateTime($affiliate_object->date_added));
               $affiliate->setStatus($affiliate_object->status);
               $affiliate->setWantsAlerts($affiliate_object->wants_alerts);
               $affiliate->setReferralId($affiliate_object->referral_id);
          
               $manager->persist($affiliate); 
               
               $affiliate_user = new AffiliateUser(); 
               $affiliate_user->setAffiliateUserId($affiliate_user_object->id);  
               $affiliate_user->setEmail($affiliate_user_object->email);
               $affiliate_user->setTitle($affiliate_user_object->title);
               $affiliate_user->setFirstName($affiliate_user_object->first_name);
               $affiliate_user->setLastName($affiliate_user_object->last_name);
               $affiliate_user->setStatus($affiliate_user_object->status);
               $affiliate_user->setIsCreator($affiliate_user_object->is_creator);
               $affiliate_user->setJoinDate(new \DateTime($affiliate_user_object->join_date));
               $affiliate_user->setAffiliate($affiliate); 
                    
               if($affiliate_object->status != 'active')
               {
                 $affiliate_user->setIsActive(false);    
               }
             
               $manager->persist($affiliate_user);  
               
               $manager->flush();
               
               return $this->redirect($this->generateUrl('login_after_register', array('username'=>$email, 'password'=>$password)));
            }
            else
            {    
              $errors[] = $translator->trans($hasoffer_errors[0]->err_msg);
              //$errors[] = $hasoffer_errors[0]->publicMessage;
            }
          }
        }
        
        return $this->render('AnytvDashboardBundle:Default:signup.html.twig', array('title'=>$translator->trans('CREATE AN ACCOUNT'), 'form'=>$form->createView(), 'id'=>$id, 'errors'=>$errors, 'country_is_listed'=>$country_is_listed));
    }
}
