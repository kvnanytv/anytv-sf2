<?php

namespace Anytv\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Anytv\DashboardBundle\Entity\TrafficReferral;
use Anytv\DashboardBundle\Entity\Affiliate;
use Anytv\DashboardBundle\Entity\Offer;

class TrafficReferralController extends Controller
{
    public function indexAction(Request $request, $page)
    {
      $session = $this->get('session');
      $translator = $this->get('translator');
      
      $form = $this->createFormBuilder(array('traffic_referral_date'=>$session->get('traffic_referral_date', new \DateTime(date('Y-m-d')))))
        ->add('traffic_referral_date', 'date')
        ->add('run_report', 'submit', array('label'=>$translator->trans('Run report')))
        ->getForm();
        
      $form->handleRequest($request);

      if($form->isValid()) 
      {
        $data = $form->getData();
        $traffic_referral_date = $data['traffic_referral_date']; 
        $session->set('traffic_referral_date', $traffic_referral_date);
        $manager = $this->getDoctrine()->getManager();
          
        $hasoffers = $this->get('hasoffers');
        $traffic_referrals_data = $hasoffers->getTrafficReferrals($traffic_referral_date);
        
        $traffic_referral_repository = $manager->getRepository('AnytvDashboardBundle:TrafficReferral');
        $affiliate_repository = $manager->getRepository('AnytvDashboardBundle:Affiliate');
        $offer_repository = $manager->getRepository('AnytvDashboardBundle:Offer');
        
        foreach($traffic_referrals_data as $traffic_referral_data)
        {
          $traffic_referral_stat_object = $traffic_referral_data->Stat;
          
          $affiliate = null;
          if($traffic_referral_stat_object->affiliate_id)
          {
            $affiliate = $affiliate_repository->findOneByAffiliateId($traffic_referral_stat_object->affiliate_id);        
          }
          
          $offer = null;
          if($traffic_referral_stat_object->offer_id)
          {
            $offer = $offer_repository->findOneByOfferId($traffic_referral_stat_object->offer_id);    
          }
          
          $traffic_referral = null;
          if($affiliate && $offer)
          {
            $traffic_referral = $traffic_referral_repository->findOneBy(array('affiliate'=>$affiliate, 'offer'=>$offer, 'url'=>$traffic_referral_stat_object->url, 'statDate'=>new \DateTime($traffic_referral_stat_object->date)));
          }
          
          if($traffic_referral)
          {
            $traffic_referral->setCount($traffic_referral_stat_object->count);
            $traffic_referral->setClicks($traffic_referral_stat_object->clicks);
            $traffic_referral->setConversions($traffic_referral_stat_object->conversions);
          }
          else
          {
            $traffic_referral = new TrafficReferral();
          
            if($affiliate)
            {
              $traffic_referral->setAffiliate($affiliate);      
            }
          
            if($offer)
            {
              $traffic_referral->setOffer($offer);      
            }
          
            $traffic_referral->setUrl($traffic_referral_stat_object->url);
            $traffic_referral->setClicks($traffic_referral_stat_object->clicks);
            $traffic_referral->setConversions($traffic_referral_stat_object->conversions);
            $traffic_referral->setLikes(0);
            $traffic_referral->setDislikes(0);
            $traffic_referral->setCount($traffic_referral_stat_object->count);
            $traffic_referral->setStatDate(new \DateTime($traffic_referral_stat_object->date));

            $manager->persist($traffic_referral);    
          }
        }

        $manager->flush();
          
        return $this->redirect($this->generateUrl('traffic_referrals'));
      }
        
      $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:TrafficReferral');
            
      $traffic_referral_date = $session->get('traffic_referral_date', new \DateTime(date('Y-m-d')));
      $items_per_page = 30;
      $order_by = 'clicks';
      $order = 'DESC';
        
      $traffic_referrals = $repository->findAllTrafficReferrals($page, $items_per_page, $order_by, $order, $traffic_referral_date);
      $total_traffic_referrals = $repository->countAllTrafficReferrals($traffic_referral_date);
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
