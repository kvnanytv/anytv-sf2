<?php

namespace Anytv\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class OfferController extends Controller
{
    public function indexAction($page)
    {
        $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Offer');
        
        $items_per_page = 10;
        $status = 'active';
        $order_by = 'offerId';
        $order = 'ASC';
        
        $offers = $repository->findAllOffers($page, $items_per_page, $status, $order_by, $order);
        $total_offers = $repository->countAllOffers($status);
        $total_pages = ceil($total_offers / $items_per_page);
       
        return $this->render('AnytvDashboardBundle:Offer:index.html.twig', array('title'=>'Offers', 'offers'=>$offers, 'total_offers'=>$total_offers, 'total_pages'=>$total_pages));
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
