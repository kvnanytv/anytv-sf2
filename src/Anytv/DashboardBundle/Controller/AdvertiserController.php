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
        
        foreach($advertisers as $advertiser)
        {
          $advertiser->setStatus($translator->trans($advertiser->getStatus()));
        }
        
        return $this->render('AnytvDashboardBundle:Advertiser:index.html.twig', array('title'=>$translator->trans('Advertisers'), 'advertisers'=>$advertisers));
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
    
    public function viewAction($id)
    {
      $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Advertiser');
      $translator = $this->get('translator');
      
      $advertiser = $repository->find($id);

      if (!$advertiser) {
        throw $this->createNotFoundException(
            'No advertiser found for id '.$id
        );
      }
      
      $offers = $advertiser->getOffers();
      
      return $this->render('AnytvDashboardBundle:Advertiser:view.html.twig', array('title'=>$advertiser, 'advertiser'=>$advertiser, 'advertiser_status'=>$translator->trans($advertiser->getStatus()), 'offers'=>$offers));
    }   
}
