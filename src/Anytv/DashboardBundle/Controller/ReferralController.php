<?php

namespace Anytv\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Anytv\DashboardBundle\Entity\Referral;

class ReferralController extends Controller
{
    public function indexAction(Request $request, $page)
    {
        $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Referral');
        $affiliate_repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Affiliate');
        $translator = $this->get('translator');
        
        $form = $this->createFormBuilder()
        ->add('referral_update', 'submit', array('label'=>$translator->trans('update')))
        ->getForm();
        
        $form->handleRequest($request);
        
        if($form->isValid()) 
        {
          if($form->get('referral_update')->isClicked())
          {
            $max_referral_date = $repository->getMaxReferralDate();
            $manager = $this->getDoctrine()->getManager();
          
            $hasoffers = $this->get('hasoffers');
            $referrals_data = $hasoffers->getReferrals($max_referral_date);
            
            foreach($referrals_data as $referral_data)
            {
              $referral_object = $referral_data->Stat;
              
              $referrer = $affiliate_repository->findOneBy(array('affiliateId'=>$referral_object->referral_id));
              $referred = $affiliate_repository->findOneBy(array('affiliateId'=>$referral_object->affiliate_id));
              $date = new \DateTime($referral_object->date);
              $amount = $referral_object->amount;
              
              if($referrer && $referred)
              {
                if($referral = $repository->findOneBy(array('referrer'=>$referrer, 'referred'=>$referred, 'date'=>$date)))
                {
                  $referral->setAmount($amount);    
                }
                else
                {
                  $referral = new Referral();
                  $referral->setReferrer($referrer);
                  $referral->setReferred($referred);
                  $referral->setAmount($amount);
                  $referral->setDate($date);
                  
                  $manager->persist($referral);
                }
              }
            }
            
            $manager->flush();
          
            return $this->redirect($this->generateUrl('referrals'));
          } 
        }
        
        $items_per_page = 30;
        $order_by = 'id';
        $order = 'DESC';
        
        $referrals = $repository->findAllReferrals($page, $items_per_page, $order_by, $order);
        $total_referrals = $repository->countAllReferrals();
        $total_pages = ceil($total_referrals / $items_per_page);
        
        return $this->render('AnytvDashboardBundle:Referral:index.html.twig', array('title'=>$translator->trans('Referrals'), 'referrals'=>$referrals, 'total_referrals'=>$total_referrals, 'page'=>$page, 'total_pages'=>$total_pages, 'form'=>$form->createView()));
    }
    
    
}
