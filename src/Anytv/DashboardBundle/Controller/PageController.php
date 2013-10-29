<?php

namespace Anytv\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Anytv\MainBundle\Entity\Page;
use Anytv\MainBundle\Form\Type\PageType;

class PageController extends Controller
{
    public function indexAction(Request $request)
    {   
        $repository = $this->getDoctrine()->getRepository('AnytvMainBundle:Page');
        $session = $this->get('session');
        $translator = $this->get('translator');
        
        $pages = $repository->findAll();

        return $this->render('AnytvDashboardBundle:Page:index.html.twig', array('title'=>$translator->trans('Pages'), 'pages'=>$pages));
    }
    
    public function editAction(Request $request, $id)
    {
      $repository = $this->getDoctrine()->getRepository('AnytvMainBundle:Page');
      
      $page = $repository->find($id);

      if (!$page) {
        throw $this->createNotFoundException(
            'No page found for id '.$id
        );
      }

      $form = $this->createForm(new PageType(), $page);

      $form->handleRequest($request);

      if ($form->isValid()) {
        
        $page = $form->getData();
        
        $em = $this->getDoctrine()->getManager();
        
        $em->persist($page);
        $em->flush();

        return $this->redirect($this->generateUrl('page_edit', array('id'=>$page->getId())));
      }

      return $this->render('AnytvDashboardBundle:Page:edit.html.twig', array('title'=>'Edit Page', 'form'=>$form->createView(), 'page'=>$page));
    }
}
