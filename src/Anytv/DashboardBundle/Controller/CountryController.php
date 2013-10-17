<?php

namespace Anytv\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Anytv\DashboardBundle\Entity\Country;

class CountryController extends Controller
{
    public function indexAction(Request $request, $page)
    {   
        $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Country');
        $session = $this->get('session');
        $translator = $this->get('translator');
        
        $form = $this->createFormBuilder(array('country_keyword'=>$session->get('country_keyword')))
        ->add('country_keyword')
        ->add('search', 'submit', array('label'=>$translator->trans('search')))
        ->getForm();
        
        $form->handleRequest($request);

        $country_keyword = null;
       
        if($form->isValid()) 
        {
          $data = $form->getData();
          $country_keyword = $data['country_keyword']; 
          $session->set('country_keyword', $country_keyword);
        }
        
        $items_per_page = 10;
        $order_by = 'name';
        $order = 'ASC';
        
        $countries = $repository->findAllCountries($page, $items_per_page, $order_by, $order, $session->get('country_keyword'));
        $total_countries = $repository->countAllCountries($session->get('country_keyword'));
        $total_pages = ceil($total_countries / $items_per_page);
        
        return $this->render('AnytvDashboardBundle:Country:index.html.twig', array('title'=>$translator->trans('Countries'), 'countries'=>$countries, 'total_countries'=>$total_countries, 'page'=>$page, 'total_pages'=>$total_pages, 'form'=>$form->createView()));
    }
    
    public function resetAction()
    {
        $session = $this->get('session');
        $session->set('country_keyword', null);
        
        return $this->redirect($this->generateUrl('countries'));
    }
    
    public function viewAction($id)
    {
      $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Country');
      $affiliate_repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Affiliate');
      $translator = $this->get('translator');
      
      $country = $repository->find($id);

      if (!$country) {
        throw $this->createNotFoundException(
            'No country found for id '.$id
        );
      }
      
      $advertisers = $country->getAdvertisers();
      $regions = $country->getRegions();
      $active_affiliates = $affiliate_repository->findAllAffiliatesByCountry($id, 'active');
      $pending_affiliates = $affiliate_repository->findAllAffiliatesByCountry($id, 'pending');
      $deleted_affiliates = $affiliate_repository->findAllAffiliatesByCountry($id, 'deleted');
      $blocked_affiliates = $affiliate_repository->findAllAffiliatesByCountry($id, 'blocked');
      $rejected_affiliates = $affiliate_repository->findAllAffiliatesByCountry($id, 'rejected');
      
      $offers = $country->getOffers();

      return $this->render('AnytvDashboardBundle:Country:view.html.twig', array('title'=>$country, 'country'=>$country, 'regions'=>$regions, 'advertisers'=>$advertisers, 'active_affiliates'=>$active_affiliates, 'pending_affiliates'=>$pending_affiliates, 'deleted_affiliates'=>$deleted_affiliates, 'blocked_affiliates'=>$blocked_affiliates, 'rejected_affiliates'=>$rejected_affiliates,  'offers'=>$offers));
    }   
}
