<?php

namespace Anytv\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Anytv\DashboardBundle\Entity\Affiliate;
use Anytv\DashboardBundle\Entity\AffiliateUser;
use Anytv\DashboardBundle\Form\Type\CompanyType;
use Anytv\DashboardBundle\Form\Type\ProfileType;

class ProfileController extends Controller
{
    public function viewAction()
    {
      $affiliate_user = $this->getUser();
      $translator = $this->get('translator');
      
   
      if (!$affiliate_user) {
        throw $this->createNotFoundException(
            'No user found'
        );
      }
      
      $affiliate = $affiliate_user->getAffiliate();

      return $this->render('AnytvDashboardBundle:Profile:view.html.twig', array('title'=>$affiliate, 'affiliate_user'=>$affiliate_user, 'affiliate'=>$affiliate, 'affiliate_user_status'=>$translator->trans($affiliate_user->getStatus()), 'affiliate_status'=>$translator->trans($affiliate->getStatus())));
    }   
    
    public function editAction(Request $request)
    {
      $affiliate_user = $this->getUser();

      if (!$affiliate_user) {
        throw $this->createNotFoundException(
            'No user found for id'
        );
      }

      $form = $this->createForm(new ProfileType(), $affiliate_user);

      $form->handleRequest($request);

      if ($form->isValid()) {
        
        $affiliate_user = $form->getData();
        
        $em = $this->getDoctrine()->getManager();
        
        $em->flush();

        return $this->redirect($this->generateUrl('profile_view'));
      }
      
      $affiliate = $affiliate_user->getAffiliate();

      return $this->render('AnytvDashboardBundle:Profile:edit.html.twig', array('title'=>'Edit my profile', 'form'=>$form->createView(), 'affiliate_user'=>$affiliate_user, 'affiliate'=>$affiliate));
    }
    
    public function companyEditAction(Request $request)
    {
      $affiliate_user = $this->getUser();
      
      $affiliate = $affiliate_user->getAffiliate();

      if (!$affiliate) {
        throw $this->createNotFoundException(
            'No affiliate found for id '.$id
        );
      }

      $form = $this->createForm(new CompanyType(), $affiliate);

      $form->handleRequest($request);

      if ($form->isValid()) {
        
        $affiliate = $form->getData();
        
        $em = $this->getDoctrine()->getManager();
        
        $em->persist($affiliate);
        $em->flush();

        return $this->redirect($this->generateUrl('profile_view'));
      }

      return $this->render('AnytvDashboardBundle:Profile:companyEdit.html.twig', array('title'=>'Edit '.$affiliate, 'form'=>$form->createView(), 'affiliate'=>$affiliate));
    }
    
    public function idCardAction($affiliate, $affiliate_user)
    {
      return $this->render('AnytvDashboardBundle:Profile:idCard.html.twig', array('affiliate'=>$affiliate, 'affiliate_user'=>$affiliate_user));
    }
    
    public function tabbedComponentAction($affiliate, $affiliate_user)
    {
      return $this->render('AnytvDashboardBundle:Profile:tabbedComponent.html.twig', array('affiliate'=>$affiliate, 'affiliate_user'=>$affiliate_user));
    }
     
    public function myOffersAction($page)
    {
      $affiliate_user = $this->getUser();

      if (!$affiliate_user) {
        throw $this->createNotFoundException(
            'No user found'
        );
      }
      
      $affiliate = $affiliate_user->getAffiliate();
      
      return $this->render('AnytvDashboardBundle:Profile:myOffers.html.twig', array('affiliate'=>$affiliate, 'affiliate_user'=>$affiliate_user, 'page'=>$page));
    }
    
    public function browseOffersAction(Request $request, $page)
    {
      If(!$request->isXmlHttpRequest())
      {
        throw $this->createNotFoundException(
            'Invalid request'
        );
      }
      
      $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Offer');
      $offer_category_repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:OfferCategory');
      $country_repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Country');
      
      $session = $this->get('session');
      
      $keyword = $request->get('offer_keyword', null);
      $category = $request->get('offer_category', null);
      $country = $request->get('offer_country', null);
      
      if($request->request->has('offer_form_submitted'))
      {
        $session->set('offer_keyword', $keyword);
        $session->set('offer_category', $category);
        $session->set('offer_country', $country);
      }
      
      $affiliate_user = $this->getUser();

      if (!$affiliate_user) {
        throw $this->createNotFoundException(
            'No user found'
        );
      }
      
      $affiliate = $affiliate_user->getAffiliate();
      
      $items_per_page = 10;
      $order_by = 'name';
      $order = 'ASC';
        
      $offers = $repository->findAllOffers($page, $items_per_page, $order_by, $order, $session->get('offer_keyword', null), 'active', $session->get('offer_category', null), $session->get('offer_country', null));
      $total_offers = $repository->countAllOffers($session->get('offer_keyword', null), 'active', $session->get('offer_category', null), $session->get('offer_country', null));
      $total_pages = ceil($total_offers / $items_per_page);
      
      $offer_categories = $offer_category_repository->findAll();
      
      $countries = $country_repository->findAll();

      return $this->render('AnytvDashboardBundle:Profile:browseOffers.html.twig', array('affiliate'=>$affiliate, 'affiliate_user'=>$affiliate_user, 'offers'=>$offers, 'total_offers'=>$total_offers, 'page'=>$page, 'total_pages'=>$total_pages, 'countries'=>$countries, 'offer_categories'=>$offer_categories, 'offer_keyword'=>$session->get('offer_keyword', null), 'selected_offer_category'=>$session->get('offer_category', null), 'selected_offer_country'=>$session->get('offer_country')));
    }
    
    public function partnersAction($page)
    {
      $affiliate_user = $this->getUser();

      if (!$affiliate_user) {
        throw $this->createNotFoundException(
            'No user found'
        );
      }
      
      $affiliate = $affiliate_user->getAffiliate();
      
      return $this->render('AnytvDashboardBundle:Profile:partners.html.twig', array('affiliate'=>$affiliate, 'affiliate_user'=>$affiliate_user, 'page'=>$page));
    }
}