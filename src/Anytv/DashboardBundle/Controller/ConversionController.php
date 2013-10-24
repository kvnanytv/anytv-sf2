<?php

namespace Anytv\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Anytv\DashboardBundle\Entity\Conversion;

class ConversionController extends Controller
{
    public function indexAction(Request $request, $page)
    {
        $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Conversion');
        $affiliate_repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Affiliate');
        $offer_repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Offer');
        $translator = $this->get('translator');
        
        
        $form = $this->createFormBuilder()
        ->add('conversion_update', 'submit', array('label'=>$translator->trans('update')))
        ->getForm();
        
        $form->handleRequest($request);
        
        if($form->isValid()) 
        {
          if($form->get('conversion_update')->isClicked())
          {
            $max_conversion_id = $repository->getMaxConversionId();
            $manager = $this->getDoctrine()->getManager();
          
            $hasoffers = $this->get('hasoffers');
            $conversions_data = $hasoffers->getConversions($max_conversion_id);
            
            foreach($conversions_data as $conversion_data)
            {
              $conversion_object = $conversion_data->Stat;
              
              $conversion = new Conversion();
              $conversion->setConversionId($conversion_object->id);
              $conversion->setIp($conversion_object->ip);
              $conversion->setTransactionId($conversion_object->ad_id);
              $conversion->setStatus($conversion_object->status);
              $conversion->setPayout($conversion_object->payout);
              $conversion->setRevenue($conversion_object->revenue);
              $conversion->setSaleAmount($conversion_object->sale_amount);
              $conversion->setIsAdjustment($conversion_object->is_adjustment);
              $conversion->setCreatedAt(new \DateTime($conversion_object->datetime));
              
              if($affiliate = $affiliate_repository->findOneBy(array('affiliateId'=>$conversion_object->affiliate_id)))
              {
                $conversion->setAffiliate($affiliate);    
              }
              
              if($offer = $offer_repository->findOneBy(array('offerId'=>$conversion_object->offer_id)))
              {
                $conversion->setOffer($offer);    
              }
             
              $manager->persist($conversion);
            }
            
            $manager->flush();
          
            return $this->redirect($this->generateUrl('conversions'));
          } 
        }
        
        $items_per_page = 30;
        $order_by = 'createdAt';
        $order = 'DESC';
        
        $conversions = $repository->findAllConversions($page, $items_per_page, $order_by, $order);
        $total_conversions = $repository->countAllConversions();
        $total_pages = ceil($total_conversions / $items_per_page);
        
        return $this->render('AnytvDashboardBundle:Conversion:index.html.twig', array('title'=>$translator->trans('Conversions'), 'conversions'=>$conversions, 'total_conversions'=>$total_conversions, 'page'=>$page, 'total_pages'=>$total_pages, 'form'=>$form->createView()));
    }
    
    
}
