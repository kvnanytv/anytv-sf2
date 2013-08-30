<?php

namespace Anytv\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NewsController extends Controller
{
    public function indexAction($page)
    {
       $repository = $this->getDoctrine()->getRepository('AnytvMainBundle:News');
        
       $items_per_page = 10;
       $order_by = 'id';
       $order = 'DESC';
        
       $news = $repository->findAllNews($page, $items_per_page, $order_by, $order);
       $total_news = $repository->countAllNews();
       $total_pages = ceil($total_news / $items_per_page);
       
       return $this->render('AnytvMainBundle:News:index.html.twig', array('title'=>'News', 'news'=>$news, 'total_news'=>$total_news, 'page'=>$page, 'total_pages'=>$total_pages));
    }
    
    
    
    
    
    
}
