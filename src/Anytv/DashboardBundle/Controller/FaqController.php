<?php

namespace Anytv\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Anytv\MainBundle\Entity\Faq;
use Anytv\MainBundle\Form\Type\FaqType;

class FaqController extends Controller
{
    public function indexAction(Request $request, $page)
    {   
        $repository = $this->getDoctrine()->getRepository('AnytvMainBundle:Faq');
        $session = $this->get('session');
        $translator = $this->get('translator');
        
        $items_per_page = 10;
        $order_by = 'question';
        $order = 'ASC';
        
        $faqs = $repository->findAllFaqs($page, $items_per_page, $order_by, $order);
        $total_faqs = $repository->countAllFaqs();
        $total_pages = ceil($total_faqs / $items_per_page);
        
        return $this->render('AnytvDashboardBundle:Faq:index.html.twig', array('title'=>$translator->trans('FAQ'), 'faqs'=>$faqs, 'total_faqs'=>$total_faqs, 'page'=>$page, 'total_pages'=>$total_pages));
    }
    
    public function editAction(Request $request, $id)
    {
      $repository = $this->getDoctrine()->getRepository('AnytvMainBundle:Faq');
      
      $faq = $repository->find($id);

      if (!$faq) {
        throw $this->createNotFoundException(
            'No faq found for id '.$id
        );
      }

      $form = $this->createForm(new FaqType(), $faq);

      $form->handleRequest($request);

      if ($form->isValid()) {
        
        $faq = $form->getData();
        
        $em = $this->getDoctrine()->getManager();
        
        $em->persist($faq);
        $em->flush();

        return $this->redirect($this->generateUrl('faq_edit', array('id'=>$faq->getId())));
      }

      return $this->render('AnytvDashboardBundle:Faq:edit.html.twig', array('title'=>'Edit FAQ', 'form'=>$form->createView(), 'faq'=>$faq));
    }
}
