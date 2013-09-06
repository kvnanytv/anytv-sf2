<?php

namespace Anytv\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Anytv\MainBundle\Entity\News;
use Anytv\MainBundle\Form\Type\NewsType;

class NewsController extends Controller
{
    public function indexAction(Request $request, $page)
    {
       $repository = $this->getDoctrine()->getRepository('AnytvMainBundle:News');
       $session = $this->get('session');
       
       $form = $this->createFormBuilder(array('news_keyword'=>$session->get('news_keyword')))
        ->add('news_keyword')
        ->add('search', 'submit')
        ->getForm();

       $form->handleRequest($request);

       $keyword = null;
       
       if($form->isValid()) 
       {
         $data = $form->getData();
         $keyword = $data['news_keyword'];
         $session->set('news_keyword', $keyword);
       }
        
       $items_per_page = 10;
       $order_by = 'id';
       $order = 'DESC';
        
       $news = $repository->findAllNews($page, $items_per_page, $order_by, $order, $session->get('news_keyword'));
       $total_news = $repository->countAllNews($session->get('news_keyword'));
       $total_pages = ceil($total_news / $items_per_page);
       
       return $this->render('AnytvMainBundle:News:index.html.twig', array('title'=>'News', 'news'=>$news, 'total_news'=>$total_news, 'page'=>$page, 'total_pages'=>$total_pages, 'form'=>$form->createView()));
    }
    
    public function resetAction()
    {
        $session = $this->get('session');
        $session->set('news_keyword', null);
        
        return $this->redirect($this->generateUrl('news'));
    }
    
    public function addAction(Request $request)
    {
      $news = new News();
      //$news->setTitle('Title here');

      $form = $this->createForm(new NewsType(), $news);
      
      
      //$form = $this->createFormBuilder($news)
        // ...
        //->add('previousStep', 'submit', array(
          //'validation_groups' => false,
        //))
        //->getForm();
      
      // isSubmitted() to check whether a form was submitted

      $form->handleRequest($request);

      if ($form->isValid()) {
        // perform some action, such as saving the task to the database
          
        $title = $form->get('title')->getData();
        
        $news = $form->getData();
        
        $news->setViewCount(0);
        $news->setCommentCount(0);
        
        $em = $this->getDoctrine()->getManager();
        
        $em->persist($news);
        $em->flush();
          
        //$nextAction = $form->get('saveAndAdd')->isClicked() ? 'task_new' : 'task_success';

        return $this->redirect($this->generateUrl('news'));
      }

      // notes
      // novalidate attribute to the form tag or formnovalidate to the submit tag - to bypass html5 validation
      
      
      return $this->render('AnytvMainBundle:News:add.html.twig', array('title'=>'Add News', 'form'=>$form->createView()));
    }
    
    public function editAction(Request $request, $id)
    {
      $repository = $this->getDoctrine()->getRepository('AnytvMainBundle:News');
      
      $news = $repository->find($id);

      if (!$news) {
        throw $this->createNotFoundException(
            'No news found for id '.$id
        );
      }

      $form = $this->createForm(new NewsType(), $news);

      $form->handleRequest($request);

      if ($form->isValid()) {
        
        $news = $form->getData();
        
        $em = $this->getDoctrine()->getManager();
        
        $em->persist($news);
        $em->flush();

        return $this->redirect($this->generateUrl('news'));
      }

      return $this->render('AnytvMainBundle:News:edit.html.twig', array('title'=>'Edit News', 'form'=>$form->createView(), 'news'=>$news));
    }
    
    public function viewAction(Request $request, $id)
    {
        $session = $this->get('session');
        $session->set('foo', $bar);
    }
}
