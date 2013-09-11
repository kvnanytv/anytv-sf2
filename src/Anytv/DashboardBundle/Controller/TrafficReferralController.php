<?php

namespace Anytv\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TrafficReferralController extends Controller
{
    public function indexAction(Request $request, $page)
    {
        $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:TrafficReferral');
        $session = $this->get('session');
        $translator = $this->get('translator');
        
        $form = $this->createFormBuilder(array('stat_date'=>$session->get('stat_date')))
        ->add('stat_date')
        ->add('search', 'submit')
        ->getForm();
        
        $form->handleRequest($request);

        $stat_date = null;
       
        if($form->isValid()) 
        {
          $data = $form->getData();
          $stat_date = $data['stat_date']; 
          $session->set('stat_date', $stat_date);
        }
        
        $items_per_page = 30;
        $order_by = 'clicks';
        $order = 'DESC';
        
        $traffic_referrals = $repository->findAllTrafficReferrals($page, $items_per_page, $order_by, $order);
        $total_traffic_referrals = $repository->countAllTrafficReferrals();
        $total_pages = ceil($total_traffic_referrals / $items_per_page);
        
        return $this->render('AnytvDashboardBundle:TrafficReferral:index.html.twig', array('title'=>$translator->trans('Traffic Referrals'), 'traffic_referrals'=>$traffic_referrals, 'total_traffic_referrals'=>$total_traffic_referrals, 'page'=>$page, 'total_pages'=>$total_pages, 'form'=>$form->createView()));
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
