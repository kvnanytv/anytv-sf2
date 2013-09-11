<?php

namespace Anytv\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Anytv\MainBundle\Entity\NewsCategory;
use Anytv\MainBundle\Form\Type\NewsCategoryType;

class NewsCategoryController extends Controller
{
    public function indexAction($page)
    {
       $repository = $this->getDoctrine()->getRepository('AnytvMainBundle:NewsCategory');
       $translator = $this->get('translator');
        
       $items_per_page = 10;
       $order_by = 'id';
       $order = 'DESC';
        
       $news_categories = $repository->findAllNewsCategories($page, $items_per_page, $order_by, $order);
       $total_news_categories = $repository->countAllNewsCategories();
       $total_pages = ceil($total_news_categories / $items_per_page);
       
       return $this->render('AnytvMainBundle:NewsCategory:index.html.twig', array('title'=>$translator->trans('News Categories'), 'news_categories'=>$news_categories, 'total_news_categories'=>$total_news_categories, 'page'=>$page, 'total_pages'=>$total_pages));
    }
    
    public function addAction(Request $request)
    {
      $translator = $this->get('translator');
      
      $news_category = new NewsCategory();

      $form = $this->createForm(new NewsCategoryType(), $news_category);

      $form->handleRequest($request);

      if ($form->isValid()) {
        
        $news_category = $form->getData();
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($news_category);
        $em->flush();

        return $this->redirect($this->generateUrl('news_category'));
      }
      
      return $this->render('AnytvMainBundle:NewsCategory:add.html.twig', array('title'=>$translator->trans('Add a news category'), 'form'=>$form->createView()));
    }
    
    
    
    
}
