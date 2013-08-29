<?php

namespace Anytv\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NewsController extends Controller
{
    public function indexAction($page)
    {
        $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:News');
      
        $news = $repository->findAll();
        
        return $this->render('AnytvDashboardBundle:News:index.html.twig', array('title'=>'News', 'news'=>$news));
    }
    
    
    
    
    
    
}
