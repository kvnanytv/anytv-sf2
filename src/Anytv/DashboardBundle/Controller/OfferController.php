<?php

namespace Anytv\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Anytv\DashboardBundle\Entity\Offer;
use Anytv\DashboardBundle\Form\Type\OfferType;

class OfferController extends Controller
{
    public function indexAction(Request $request, $page)
    {
        //$hasoffers = $this->get('hasoffers');
        //$offers_data = $hasoffers->getOffers();
          
        $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Offer');
        $session = $this->get('session');
        $translator = $this->get('translator');
        
        $form = $this->createFormBuilder(array('offer_keyword'=>$session->get('offer_keyword'), 'offer_status'=>$session->get('offer_status', 'active')))
        ->add('offer_keyword', 'text', array('required'=>false))
        ->add('offer_status', 'choice', array('required' => true, 'choices' => array('active'=>'active', 'paused'=>'paused', 'pending'=>'pending', 'expired'=>'expired', 'deleted'=>'deleted')))
        ->add('search', 'submit', array('label'=>$translator->trans('search')))
        ->getForm();
        
        $form->handleRequest($request);

        $offer_keyword = null;
        $offer_status = 'active';
       
        if($form->isValid()) 
        {
          $data = $form->getData();
          $offer_keyword = $data['offer_keyword']; 
          $session->set('offer_keyword', $offer_keyword);
          $offer_status = $data['offer_status']; 
          $session->set('offer_status', $offer_status);
        }
        
        $items_per_page = 10;
        $status = 'active';
        $order_by = 'name';
        $order = 'ASC';
        
        $offers = $repository->findAllOffers($page, $items_per_page, $status, $order_by, $order, $session->get('offer_keyword'), $session->get('offer_status'));
        $total_offers = $repository->countAllOffers($status, $session->get('offer_keyword'), $session->get('offer_status'));
        $total_pages = ceil($total_offers / $items_per_page);
       
        return $this->render('AnytvDashboardBundle:Offer:index.html.twig', array('title'=>$translator->trans('Offers'), 'offers'=>$offers, 'total_offers'=>$total_offers, 'page'=>$page, 'total_pages'=>$total_pages, 'form'=>$form->createView()));
    }
    
    public function resetAction()
    {
        $session = $this->get('session');
        $session->set('offer_keyword', null);
        $session->set('offer_status', 'active');
        
        return $this->redirect($this->generateUrl('offers'));
    }
    
    public function editAction(Request $request, $id)
    {
      $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Offer');
      $translator = $this->get('translator');
      
      $offer = $repository->find($id);

      if (!$offer) {
        throw $this->createNotFoundException(
            'No offer found for id '.$id
        );
      }

      $form = $this->createForm(new OfferType(), $offer);

      $form->handleRequest($request);

      if ($form->isValid()) {
        
        $offer = $form->getData();
        
        $em = $this->getDoctrine()->getManager();
        
        $em->persist($offer);
        $em->flush();

        return $this->redirect($this->generateUrl('offer_view', array('id'=>$offer->getId())));
      }

      return $this->render('AnytvDashboardBundle:Offer:edit.html.twig', array('title'=>$translator->trans('Edit Offer'), 'form'=>$form->createView(), 'offer'=>$offer));
    }
    
    public function viewAction($id)
    {
      $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Offer');
      $country_repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Country');
      $translator = $this->get('translator');
      
      $offer = $repository->find($id);

      if (!$offer) {
        throw $this->createNotFoundException(
            'No offer found for id '.$id
        );
      }
      
      $offer_categories = $offer->getOfferCategories();
      $countries = $offer->getCountries();
      $countries_total = $country_repository->countAllCountries(null);

      return $this->render('AnytvDashboardBundle:Offer:view.html.twig', array('title'=>$offer, 'offer'=>$offer, 'offer_status'=>$translator->trans($offer->getStatus()), 'offer_categories'=>$offer_categories, 'countries'=>$countries, 'countries_total'=>$countries_total));
    }
}
