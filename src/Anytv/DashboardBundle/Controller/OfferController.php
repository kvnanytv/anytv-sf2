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
        $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Offer');
        $session = $this->get('session');
        $translator = $this->get('translator');
        
        $form = $this->createFormBuilder(array('offer_keyword'=>$session->get('offer_keyword'), 'offer_status'=>$session->get('offer_status', 'active')))
         ->add('offer_keyword', 'text', array('required'=>false))
         ->add('offer_status', 'choice', array('required' => true, 'choices' => array('active'=>'active', 'paused'=>'paused', 'pending'=>'pending', 'expired'=>'expired', 'deleted'=>'deleted')))
         ->add('offer_search', 'submit', array('label'=>$translator->trans('search')))
         ->add('offer_update', 'submit', array('label'=>$translator->trans('update')))
         ->getForm();
        
        $form->handleRequest($request);
       
        if($form->isValid()) 
        {
          if($form->get('offer_search')->isClicked())
          {
            $data = $form->getData();
            $session->set('offer_keyword', $data['offer_keyword']);
            $session->set('offer_status', $data['offer_status']);
          }
          else
          {
            $manager = $this->getDoctrine()->getManager();
            $advertiser_repository = $manager->getRepository('AnytvDashboardBundle:Advertiser');
            $offer_category_repository = $manager->getRepository('AnytvDashboardBundle:OfferCategory');
            $offer_group_repository = $manager->getRepository('AnytvDashboardBundle:OfferGroup');
            $country_repository = $manager->getRepository('AnytvDashboardBundle:Country');
            $countries = $country_repository->findAll();
          
            $hasoffers = $this->get('hasoffers');
            $offers_data = $hasoffers->getOffers();
        
            foreach($offers_data as $offer_data)
            {
              $offer_object = $offer_data->Offer;
              $offer_category_array = $offer_data->OfferCategory;
              $country_array = $offer_data->Country;
              $offer_group_array = $offer_data->OfferGroup;
          
              $offer = $repository->findOneBy(array('offerId'=>$offer_object->id));
          
              if($offer)
              {
                $offer->setName($offer_object->name);
                $offer->setDescription($offer_object->description);
                
                if($offer_object->advertiser_id && ($advertiser = $advertiser_repository->findOneByadvertiserId($offer_object->advertiser_id)))
                {
                  $offer->setAdvertiser($advertiser); 
                } 
                
                $offer->getOfferGroups()->clear();
                foreach($offer_group_array as $offer_group_object)
                {
                  if($offer_group = $offer_group_repository->findOneByOfferGroupId($offer_group_object->id))
                  {
                    $offer->addOfferGroup($offer_group); 
                  }    
                }
          
                $offer->setOfferUrl($offer_object->offer_url);
                $offer->setPreviewUrl($offer_object->preview_url);
                $offer->setProtocol($offer_object->protocol);
                $offer->setStatus($offer_object->status);
                $offer->setExpirationDate(new \DateTime($offer_object->expiration_date));
                $offer->setPayoutType($offer_object->payout_type);
                $offer->setRevenueType($offer_object->revenue_type);
                $offer->setDefaultPayout($offer_object->default_payout);
                $offer->setMaxPayout($offer_object->max_payout);
                $offer->setPercentPayout($offer_object->percent_payout);
                $offer->setMaxPercentPayout($offer_object->max_percent_payout);
                $offer->setTieredPayout($offer_object->tiered_payout);
                $offer->setCurrency($offer_object->currency);
                $offer->setIsPrivate($offer_object->is_private);
                $offer->setRequireApproval($offer_object->require_approval);
                $offer->setRequireTermsAndConditions($offer_object->require_terms_and_conditions);
                $offer->setTermsAndConditions($offer_object->terms_and_conditions);
                
                $offer->getOfferCategories()->clear();
                foreach($offer_category_array as $offer_category_object)
                {
                  if($offer_category = $offer_category_repository->findOneByOfferCategoryId($offer_category_object->id))
                  {
                    $offer->addOfferCategorie($offer_category); 
                  }
                }
                
                $offer->getCountries()->clear();
                if($country_array)
                {
                  foreach($country_array as $country_object)
                  {
                    if($country = $country_repository->findOneByCode($country_object->code))
                    {
                      $offer->addCountrie($country); 
                    } 
                  }
                }
                else
                {
                  foreach($countries as $country)
                  {
                    $offer->addCountrie($country);     
                  }
                }
              }
              else
              {
                $offer = new Offer();
                $offer->setOfferId($offer_object->id);
                $offer->setName($offer_object->name);
                $offer->setDescription($offer_object->description);
          
                if($offer_object->advertiser_id && ($advertiser = $advertiser_repository->findOneByadvertiserId($offer_object->advertiser_id)))
                {
                  $offer->setAdvertiser($advertiser); 
                } 
                
                foreach($offer_group_array as $offer_group_object)
                {
                  if($offer_group = $offer_group_repository->findOneByOfferGroupId($offer_group_object->id))
                  {
                    $offer->addOfferGroup($offer_group); 
                  }    
                }
          
                $offer->setOfferUrl($offer_object->offer_url);
                $offer->setPreviewUrl($offer_object->preview_url);
                $offer->setProtocol($offer_object->protocol);
                $offer->setStatus($offer_object->status);
                $offer->setExpirationDate(new \DateTime($offer_object->expiration_date));
                $offer->setPayoutType($offer_object->payout_type);
                $offer->setRevenueType($offer_object->revenue_type);
                $offer->setDefaultPayout($offer_object->default_payout);
                $offer->setMaxPayout($offer_object->max_payout);
                $offer->setPercentPayout($offer_object->percent_payout);
                $offer->setMaxPercentPayout($offer_object->max_percent_payout);
                $offer->setTieredPayout($offer_object->tiered_payout);
                $offer->setCurrency($offer_object->currency);
                $offer->setIsPrivate($offer_object->is_private);
                $offer->setRequireApproval($offer_object->require_approval);
                $offer->setRequireTermsAndConditions($offer_object->require_terms_and_conditions);
                $offer->setTermsAndConditions($offer_object->terms_and_conditions);
                
                foreach($offer_category_array as $offer_category_object)
                {
                  if($offer_category = $offer_category_repository->findOneByOfferCategoryId($offer_category_object->id))
                  {
                    $offer->addOfferCategorie($offer_category); 
                  }
                }
                
                if($country_array)
                {
                  foreach($country_array as $country_object)
                  {
                    if($country = $country_repository->findOneByCode($country_object->code))
                    {
                      $offer->addCountrie($country); 
                    } 
                  }
                }
                else
                {
                  foreach($countries as $country)
                  {
                    $offer->addCountrie($country);     
                  }
                }

                $manager->persist($offer);   
              }
            }

            $manager->flush();
          
            return $this->redirect($this->generateUrl('offers_reset'));    
          }
        }
        
        $items_per_page = 10;
        $order_by = 'name';
        $order = 'ASC';
        
        $offers = $repository->findAllOffers($page, $items_per_page, $order_by, $order, $session->get('offer_keyword', null), $session->get('offer_status', 'active'));
        $total_offers = $repository->countAllOffers($session->get('offer_keyword', null), $session->get('offer_status', 'active'));
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
      $offer_groups = $offer->getOfferGroups();
      $countries = $offer->getCountries();
      $countries_total = $country_repository->countAllCountries(null);

      return $this->render('AnytvDashboardBundle:Offer:view.html.twig', array('title'=>$offer, 'offer'=>$offer, 'offer_status'=>$translator->trans($offer->getStatus()), 'offer_categories'=>$offer_categories, 'offer_groups'=>$offer_groups, 'countries'=>$countries, 'countries_total'=>$countries_total));
    }
}
