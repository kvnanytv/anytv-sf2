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
        $country_repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Country');
        $session = $this->get('session');
        $translator = $this->get('translator');
        
        $countries_choices = array();
        $countries = $country_repository->findAll();
        foreach($countries as $country)
        {
          $countries_choices[$country->getId()] = $country->getName();  
        }
        
        $form = $this->createFormBuilder(array('affiliate_keyword'=>$session->get('affiliate_keyword'), 'affiliate_country'=>$session->get('affiliate_country'), 'affiliate_status'=>$session->get('affiliate_status', 'active')))
        ->add('affiliate_keyword', 'text', array('required'=>false))
        ->add('affiliate_country', 'choice', array('required' => false, 'choices' => $countries_choices, 'empty_value' => ''))
        ->add('affiliate_status', 'choice', array('required' => true, 'choices' => array('active'=>'active', 'pending'=>'pending', 'deleted'=>'deleted', 'blocked'=>'blocked', 'rejected'=>'rejected')))
        ->add('search', 'submit')
        ->getForm();
        
        $form->handleRequest($request);

        $affiliate_keyword = null;
        $affiliate_country = null;
        $affiliate_status = 'active';
        
        if($form->isValid()) 
        {
          $data = $form->getData();
          $affiliate_keyword = $data['affiliate_keyword']; 
          $session->set('affiliate_keyword', $affiliate_keyword);
          $affiliate_country = $data['affiliate_country']; 
          $session->set('affiliate_country', $affiliate_country);
          $affiliate_status = $data['affiliate_status']; 
          $session->set('affiliate_status', $affiliate_status);
        }
        
        $items_per_page = 30;
        $order_by = 'company';
        $order = 'ASC';
        
        $affiliates = $repository->findAllAffiliates($page, $items_per_page, $order_by, $order, $session->get('affiliate_keyword'), $session->get('affiliate_country'), $session->get('affiliate_status'));
        $total_affiliates = $repository->countAllAffiliates($session->get('affiliate_keyword'), $session->get('affiliate_country'), $session->get('affiliate_status'));
        $total_pages = ceil($total_affiliates / $items_per_page);
        
        return $this->render('AnytvDashboardBundle:Affiliate:index.html.twig', array('title'=>$translator->trans('Affiliates'), 'affiliates'=>$affiliates, 'total_affiliates'=>$total_affiliates, 'page'=>$page, 'total_pages'=>$total_pages, 'form'=>$form->createView()));
    }
    
    public function resetAction()
    {
        $session = $this->get('session');
        $session->set('affiliate_keyword', null);
        $session->set('affiliate_country', null);
        $session->set('affiliate_status', 'active');
        
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

        return $this->redirect($this->generateUrl('affiliate_view', array('id'=>$affiliate->getId())));
      }

      return $this->render('AnytvDashboardBundle:Affiliate:edit.html.twig', array('title'=>'Edit '.$affiliate, 'form'=>$form->createView(), 'affiliate'=>$affiliate));
    }
    
    public function viewAction($id)
    {
      $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Affiliate');
      $translator = $this->get('translator');
      
      $affiliate = $repository->find($id);

      if (!$affiliate) {
        throw $this->createNotFoundException(
            'No affiliate found for id '.$id
        );
      }
      
      $affiliate_users = $affiliate->getAffiliateUsers();

      return $this->render('AnytvDashboardBundle:Affiliate:view.html.twig', array('title'=>$affiliate, 'affiliate'=>$affiliate, 'affiliate_status'=>$translator->trans($affiliate->getStatus()), 'affiliate_users'=>$affiliate_users));
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
