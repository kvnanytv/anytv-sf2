<?php

namespace Anytv\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AffiliateUserController extends Controller
{
    public function indexAction(Request $request, $page)
    {
        $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:AffiliateUser');
        $session = $this->get('session');
        
        $form = $this->createFormBuilder(array('affiliate_user_keyword'=>$session->get('affiliate_user_keyword')))
        ->add('affiliate_user_keyword')
        ->add('search', 'submit')
        ->getForm();
        
        $form->handleRequest($request);

        $affiliate_user_keyword = null;
       
        if($form->isValid()) 
        {
          $data = $form->getData();
          $affiliate_user_keyword = $data['affiliate_user_keyword']; 
          $session->set('affiliate_user_keyword', $affiliate_user_keyword);
        }
        
        $items_per_page = 30;
        $order_by = 'affiliateUserId';
        $order = 'DESC';
        
        $affiliate_users = $repository->findAllAffiliateUsers($page, $items_per_page, $order_by, $order, $session->get('affiliate_user_keyword'));
        $total_affiliate_users = $repository->countAllAffiliateUsers($session->get('affiliate_user_keyword'));
        $total_pages = ceil($total_affiliate_users / $items_per_page);
        
        return $this->render('AnytvDashboardBundle:AffiliateUser:index.html.twig', array('title'=>'Affiliate Users', 'affiliate_users'=>$affiliate_users, 'total_affiliate_users'=>$total_affiliate_users, 'page'=>$page, 'total_pages'=>$total_pages, 'form'=>$form->createView()));
    }
    
    public function resetAction()
    {
        $session = $this->get('session');
        $session->set('affiliate_user_keyword', null);
        
        return $this->redirect($this->generateUrl('affiliate_users'));
    }
    
    public function showAction($id)
    {
      $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Offer');
      
      $offer = $repository->find($id);

      if (!$offer) {
        throw $this->createNotFoundException(
            'No offer found for id '.$id
        );
      }

      // ... do something, like pass the $offer object into a template
    }
    
    public function updateAction($id)
    {
      $em = $this->getDoctrine()->getManager();
      $offer = $em->getRepository('AnytvDashboardBundle:Offer')->find($id);

      if (!$offer) {
        throw $this->createNotFoundException(
            'No offer found for id '.$id
        );
      }

      $offer->setName('New offer name!');
      $em->flush();

      return $this->redirect($this->generateUrl('offers'));
    }
    
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
}
