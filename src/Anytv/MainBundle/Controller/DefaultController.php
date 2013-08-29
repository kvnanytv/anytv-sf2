<?php

namespace Anytv\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        // rendering different formats of same resource
        //$format = $this->getRequest()->getRequestFormat();
        //return $this->render('AnytvMainBundle:Default:index.'.$format.'.twig');
    
        return $this->render('AnytvMainBundle:Default:index.html.twig', array('title'=>'Any.TV'));
    }
}
