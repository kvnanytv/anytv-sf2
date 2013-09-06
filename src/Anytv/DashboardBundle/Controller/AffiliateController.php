<?php

namespace Anytv\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Anytv\DashboardBundle\Entity\Affiliate;
use Anytv\DashboardBundle\Form\Type\AffiliateType;

class AffiliateController extends Controller
{
    public function indexAction(Request $request, $page)
    {
        $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Affiliate');
        $session = $this->get('session');
        
        $form = $this->createFormBuilder(array('affiliate_keyword'=>$session->get('affiliate_keyword')))
        ->add('affiliate_keyword')
        ->add('search', 'submit')
        ->getForm();
        
        $form->handleRequest($request);

        $affiliate_keyword = null;
       
        if($form->isValid()) 
        {
          $data = $form->getData();
          $affiliate_keyword = $data['affiliate_keyword']; 
          $session->set('affiliate_keyword', $affiliate_keyword);
        }
        
        $items_per_page = 30;
        $order_by = 'affiliateId';
        $order = 'DESC';
        
        $affiliates = $repository->findAllAffiliates($page, $items_per_page, $order_by, $order, $session->get('affiliate_keyword'));
        $total_affiliates = $repository->countAllAffiliates($session->get('affiliate_keyword'));
        $total_pages = ceil($total_affiliates / $items_per_page);
        
        return $this->render('AnytvDashboardBundle:Affiliate:index.html.twig', array('title'=>'Affiliates', 'affiliates'=>$affiliates, 'total_affiliates'=>$total_affiliates, 'page'=>$page, 'total_pages'=>$total_pages, 'form'=>$form->createView()));
    }
    
    public function resetAction()
    {
        $session = $this->get('session');
        $session->set('affiliate_keyword', null);
        
        return $this->redirect($this->generateUrl('affiliates'));
    }
    
    public function editAction(Request $request, $id)
    {
      $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Affiliate');
      
      $affiliate = $repository->find($id);

      if (!$affiliate) {
        throw $this->createNotFoundException(
            'No affiliate found for id '.$id
        );
      }

      $form = $this->createForm(new AffiliateType(), $affiliate);

      $form->handleRequest($request);

      if ($form->isValid()) {
        
        $affiliate = $form->getData();
        
        $em = $this->getDoctrine()->getManager();
        
        $em->persist($affiliate);
        $em->flush();

        return $this->redirect($this->generateUrl('affiliates'));
      }

      return $this->render('AnytvDashboardBundle:Affiliate:edit.html.twig', array('title'=>'Edit Affiliate', 'form'=>$form->createView(), 'affiliate'=>$affiliate));
    }
    
    public function viewAction($id)
    {
      $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Affiliate');
      
      $affiliate = $repository->find($id);

      if (!$affiliate) {
        throw $this->createNotFoundException(
            'No affiliate found for id '.$id
        );
      }

      return $this->render('AnytvDashboardBundle:Affiliate:view.html.twig', array('title'=>$affiliate, 'affiliate'=>$affiliate));
    }
    
    
    /*
    public function deleteAction($id)
    {
      $em = $this->getDoctrine()->getManager();
      $offer = $em->getRepository('AnytvDashboardBundle:Offer')->find($id);

      if (!$offer) {
        throw $this->createNotFoundException(
            'No offer found for id '.$id
        );
      }

      $em->remove($offer);
      $em->flush();

      return $this->redirect($this->generateUrl('offers'));
    }
    */ 
    
}
