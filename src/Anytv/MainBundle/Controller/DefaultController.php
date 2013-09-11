<?php

namespace Anytv\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $translator = $this->get('translator');
        $name = 'Dennis';
        $translated = $translator->trans('Hi %name%', array('%name%' => $name));
        
        
        
        
        
        
        // rendering different formats of same resource
        //$format = $this->getRequest()->getRequestFormat();
        //return $this->render('AnytvMainBundle:Default:index.'.$format.'.twig');
    
        return $this->render('AnytvMainBundle:Default:index.html.twig', array('title'=>'Any.TV', 'translated'=>$translated));
    }
}
