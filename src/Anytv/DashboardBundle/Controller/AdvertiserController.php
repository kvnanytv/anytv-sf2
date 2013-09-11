<?php

namespace Anytv\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Anytv\DashboardBundle\Entity\Advertiser;
use Anytv\DashboardBundle\Form\Type\AdvertiserType;

class AdvertiserController extends Controller
{
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Advertiser');
        $translator = $this->get('translator');
        
        $advertisers = $repository->findAllAdvertisers();
        
        return $this->render('AnytvDashboardBundle:Advertiser:index.html.twig', array('title'=>$translator->trans('Advertisers'), 'advertisers'=>$advertisers));
    }
    
    public function resetAction()
    {
        $session = $this->get('session');
        $session->set('advertiser_keyword', null);
        
        return $this->redirect($this->generateUrl('advertisers'));
    }
    
    public function editAction(Request $request, $id)
    {
      $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Advertiser');
      $translator = $this->get('translator');
      
      $advertiser = $repository->find($id);

      if (!$advertiser) {
        throw $this->createNotFoundException(
            'No advertiser found for id '.$id
        );
      }

      $form = $this->createForm(new AdvertiserType(), $advertiser);

      $form->handleRequest($request);

      if ($form->isValid()) {
        
        $advertiser = $form->getData();
        
        $em = $this->getDoctrine()->getManager();
        
        $em->persist($advertiser);
        $em->flush();

        return $this->redirect($this->generateUrl('advertisers'));
      }

      return $this->render('AnytvDashboardBundle:Advertiser:edit.html.twig', array('title'=>$translator->trans('Edit Advertiser'), 'form'=>$form->createView(), 'advertiser'=>$advertiser));
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
