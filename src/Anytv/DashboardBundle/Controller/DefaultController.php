<?php

namespace Anytv\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
}
