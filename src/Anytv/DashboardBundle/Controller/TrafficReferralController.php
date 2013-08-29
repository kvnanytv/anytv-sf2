<?php

namespace Anytv\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TrafficReferralController extends Controller
{
    public function indexAction($page)
    {
        $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:TrafficReferral');
        
        $order_by = 'url';
        $order = 'ASC';
        
        $traffic_referrals = $repository->findAllTrafficReferrals($order_by, $order);
        
        return $this->render('AnytvDashboardBundle:TrafficReferral:index.html.twig', array('title'=>'Traffic Referrals', 'traffic_referrals'=>$traffic_referrals));
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
