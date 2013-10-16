<?php

namespace Anytv\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\View\ChoiceView;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;

use Anytv\DashboardBundle\Entity\Affiliate;
use Anytv\DashboardBundle\Entity\AffiliateUser;
use Anytv\DashboardBundle\Form\Type\CompanyType;
use Anytv\DashboardBundle\Form\Type\ProfileType;
use Anytv\DashboardBundle\Entity\TrackingLink;

class ProfileController extends Controller
{
    public function viewAction(Request $request, $tab, $mode)
    {
      $affiliate_user = $this->getUser();
      $translator = $this->get('translator');
      $em = $this->getDoctrine()->getManager();
      
   
      if (!$affiliate_user) {
        throw $this->createNotFoundException(
            'No user found'
        );
      }
      
      $affiliate = $affiliate_user->getAffiliate();
      
      if (!$affiliate) {
        throw $this->createNotFoundException(
            'No affiliate found'
        );
      }
      
      // paypal auto-retrieve upon profile view
      
      if($affiliate->getPaypalEmailRequested() === false)
      {
        $hasoffers = $this->get('hasoffers');
        
        if($paypal_email = $hasoffers->getPaypalEmail($affiliate->getAffiliateId()))
        {
          $affiliate->setPaypalEmail($paypal_email);
        }
        
        $affiliate->setPaypalEmailRequested(true); 
        
        $em->flush();
        
        // fetch the record again
        $affiliate = $affiliate_user->getAffiliate();
      }
      
      $form = null;
      $form_view = null;
      
      if($mode == 'edit')
      {
        if($tab == 'company')
        {
          $form = $this->createForm(new CompanyType(), $affiliate); 
        }
        elseif($tab == 'user')
        {
          $form = $this->createForm(new ProfileType(), $affiliate_user);  
        }   
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            
          $em->flush();

          if($tab == 'company')
          {
            return $this->redirect($this->generateUrl('profile_view'));   
          }
          elseif($tab == 'user')
          {
            return $this->redirect($this->generateUrl('profile_view', array('tab'=>'user')));  
          }   
        }
        
        $form_view = $form->createView();
      }

      return $this->render('AnytvDashboardBundle:Profile:view.html.twig', array('title'=>$affiliate, 'affiliate_user'=>$affiliate_user, 'affiliate'=>$affiliate, 'affiliate_user_status'=>$translator->trans($affiliate_user->getStatus()), 'affiliate_status'=>$translator->trans($affiliate->getStatus()), 'tab'=>$tab, 'mode'=>$mode, 'form'=>$form_view));
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

      return $this->render('AnytvDashboardBundle:Profile:companyEdit.html.twig', array('title'=>'Edit '.$affiliate, 'form'=>$form->createView(), 'affiliate'=>$affiliate, 'affiliate_user'=>$affiliate_user));
    }
    
    public function idCardAction($affiliate, $affiliate_user, $page)
    {
      return $this->render('AnytvDashboardBundle:Profile:idCard.html.twig', array('affiliate'=>$affiliate, 'affiliate_user'=>$affiliate_user, 'page'=>$page));
    }
    
    public function tabbedComponentAction($affiliate, $affiliate_user)
    {
      return $this->render('AnytvDashboardBundle:Profile:tabbedComponent.html.twig', array('affiliate'=>$affiliate, 'affiliate_user'=>$affiliate_user));
    }
    
    public function tabbedProfileComponentAction($tab, $mode, $form)
    {
      return $this->render('AnytvDashboardBundle:Profile:tabbedProfileComponent.html.twig', array('tab'=>$tab, 'mode'=>$mode, 'form'=>$form));
    }
     
    public function myOffersAction(Request $request, $page)
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
    
    public function partnersAction(Request $request, $page)
    {
      if(!$request->isXmlHttpRequest())
      {
        throw $this->createNotFoundException(
            'Invalid request'
        );
      }
      
      $affiliate_user = $this->getUser();

      if (!$affiliate_user) {
        throw $this->createNotFoundException(
            'No user found'
        );
      }
      
      $affiliate = $affiliate_user->getAffiliate();
      
      return $this->render('AnytvDashboardBundle:Profile:partners.html.twig', array('affiliate'=>$affiliate, 'affiliate_user'=>$affiliate_user, 'page'=>$page));
    }
    
    public function offerViewAction(Request $request, $id)
    {
      if(!$request->isXmlHttpRequest())
      {
        throw $this->createNotFoundException(
            'Invalid request'
        );
      }
      
      $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Offer');
      //$country_repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Country');
      $offer_group_repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:OfferGroup');
      $tracking_link_repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:TrackingLink');
      //$translator = $this->get('translator');
      
      $offer = $repository->find($id);

      if (!$offer) {
        throw $this->createNotFoundException(
            'No offer found for id '.$id
        );
      }
      
      $affiliate_user = $this->getUser();
   
      if (!$affiliate_user) {
        throw $this->createNotFoundException(
            'No user found'
        );
      }
      
      $affiliate = $affiliate_user->getAffiliate();
      
      if (!$affiliate) {
        throw $this->createNotFoundException(
            'No affiliate found'
        );
      }
      
      $tracking_link = $tracking_link_repository->findOneBy(array('affiliateId'=>$affiliate->getAffiliateId(), 'offerId'=>$offer->getOfferId()));
      
      if(!$tracking_link)
      {
        $hasoffers = $this->get('hasoffers');
        $tracking_link_hasoffers = $hasoffers->getPlayNowLink($offer->getOfferId(), $affiliate->getAffiliateId());
        
        if($tracking_link_hasoffers)
        {
          $manager = $this->getDoctrine()->getManager();
          
          $tracking_link = new TrackingLink();
          $tracking_link->setAffiliateId($tracking_link_hasoffers->affiliate_id);
          $tracking_link->setOfferId($tracking_link_hasoffers->offer_id);
          $tracking_link->setClickUrl($tracking_link_hasoffers->click_url);
          
          $manager->persist($tracking_link);   
          $manager->flush();
        }
      }
      
      $offer_categories = $offer->getOfferCategories();
      $offer_group = $offer_group_repository->findOneOfferGroupByOffer($id);
      $countries = $offer->getCountries();

      return $this->render('AnytvDashboardBundle:Profile:offerView.html.twig', array('offer'=>$offer, 'offer_categories'=>$offer_categories, 'offer_group'=>$offer_group, 'countries'=>$countries, 'tracking_link'=>$tracking_link));
    }
    
    public function myVideosAction(Request $request, $page)
    {
      if(!$request->isXmlHttpRequest())
      {
        throw $this->createNotFoundException(
            'Invalid request'
        );
      }
      
      $affiliate_user = $this->getUser();

      if (!$affiliate_user) {
        throw $this->createNotFoundException(
            'No user found'
        );
      }
      
      $affiliate = $affiliate_user->getAffiliate();
      
      return $this->render('AnytvDashboardBundle:Profile:myVideos.html.twig', array('affiliate'=>$affiliate, 'affiliate_user'=>$affiliate_user, 'page'=>$page));
    }
    
    public function companyAction(Request $request, $mode, $form)
    {
      $translator = $this->get('translator');
      $affiliate_user = $this->getUser();

      if (!$affiliate_user) {
        throw $this->createNotFoundException(
            'No user found'
        );
      }
      
      $affiliate = $affiliate_user->getAffiliate();
      
      return $this->render('AnytvDashboardBundle:Profile:company.html.twig', array('affiliate'=>$affiliate, 'mode'=>$mode, 'form'=>$form));
    }
    
    public function userAction(Request $request, $mode, $form)
    {
      $translator = $this->get('translator');
      $affiliate_user = $this->getUser();

      if (!$affiliate_user) {
        throw $this->createNotFoundException(
            'No user found'
        );
      }
      
      $affiliate = $affiliate_user->getAffiliate();
      
      return $this->render('AnytvDashboardBundle:Profile:user.html.twig', array('title'=>$affiliate, 'affiliate_user'=>$affiliate_user, 'affiliate'=>$affiliate, 'affiliate_user_status'=>$translator->trans($affiliate_user->getStatus()), 'affiliate_status'=>$translator->trans($affiliate->getStatus()), 'mode'=>$mode, 'form'=>$form));
    }
    
    public function offerViewPopupAction()
    {
      return $this->render('AnytvDashboardBundle:Profile:offerViewPopup.html.twig');
    }
}