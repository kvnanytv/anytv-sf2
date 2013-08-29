<?php

namespace Anytv\CommunityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AnytvCommunityBundle:Default:index.html.twig', array('title'=>'Any.TV Community'));
    }
}
