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
        
        $form = $this->createFormBuilder()
        ->add('advertisers_update', 'submit', array('label'=>$translator->trans('update')))
        ->getForm();
        
        $form->handleRequest($request);
      
        if($form->isValid()) 
        {
          $manager = $this->getDoctrine()->getManager();
          
          $hasoffers = $this->get('hasoffers');
          $advertisers_data = $hasoffers->getAdvertisers();
          $country_repository = $manager->getRepository('AnytvDashboardBundle:Country');
        
          foreach($advertisers_data as $advertiser_data)
          {
            $advertiser_object = $advertiser_data->Advertiser;
            
            $advertiser = $repository->findOneBy(array('advertiserId'=>$advertiser_object->id));
          
            if($advertiser)
            {
              $advertiser->setCompany($advertiser_object->company);
              $advertiser->setStatus($advertiser_object->status);
              $advertiser->setAddress1($advertiser_object->address1);
              $advertiser->setAddress2($advertiser_object->address2);
              $advertiser->setCity($advertiser_object->city);
              $advertiser->setRegion($advertiser_object->region);
          
              if($country = $country_repository->findOneByCode($advertiser_object->country))
              {
                $advertiser->setCountry($country);         
              } 
          
              $advertiser->setOther($advertiser_object->other);
              $advertiser->setZipcode($advertiser_object->zipcode);
              $advertiser->setPhone($advertiser_object->phone);
              $advertiser->setFax($advertiser_object->fax);
              $advertiser->setWebsite($advertiser_object->website);
              $advertiser->setWantsAlerts($advertiser_object->wants_alerts);
              $advertiser->setAccountManagerId($advertiser_object->account_manager_id);
              $advertiser->setSignupIp($advertiser_object->signup_ip);
              $advertiser->setRefId($advertiser_object->ref_id);
              $advertiser->setCreatedAt(new \DateTime($advertiser_object->date_added));
              $advertiser->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s', $advertiser_object->modified)));  
            }
            else
            {
              $advertiser = new Advertiser();
              $advertiser->setAdvertiserId($advertiser_object->id);
              $advertiser->setCompany($advertiser_object->company);
              $advertiser->setStatus($advertiser_object->status);
              $advertiser->setAddress1($advertiser_object->address1);
              $advertiser->setAddress2($advertiser_object->address2);
              $advertiser->setCity($advertiser_object->city);
              $advertiser->setRegion($advertiser_object->region);
          
              if($country = $country_repository->findOneByCode($advertiser_object->country))
              {
                $advertiser->setCountry($country);         
              } 
          
              $advertiser->setOther($advertiser_object->other);
              $advertiser->setZipcode($advertiser_object->zipcode);
              $advertiser->setPhone($advertiser_object->phone);
              $advertiser->setFax($advertiser_object->fax);
              $advertiser->setWebsite($advertiser_object->website);
              $advertiser->setWantsAlerts($advertiser_object->wants_alerts);
              $advertiser->setAccountManagerId($advertiser_object->account_manager_id);
              $advertiser->setSignupIp($advertiser_object->signup_ip);
              $advertiser->setRefId($advertiser_object->ref_id);
              $advertiser->setCreatedAt(new \DateTime($advertiser_object->date_added));
              $advertiser->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s', $advertiser_object->modified)));

              $manager->persist($advertiser);    
            }
          }

          $manager->flush();
          
          return $this->redirect($this->generateUrl('advertisers'));    
        }
        
        $advertisers = $repository->findAllAdvertisers();
        
        foreach($advertisers as $advertiser)
        {
          $advertiser->setStatus($translator->trans($advertiser->getStatus()));
        }
        
        return $this->render('AnytvDashboardBundle:Advertiser:index.html.twig', array('title'=>$translator->trans('Advertisers'), 'advertisers'=>$advertisers, 'form'=>$form->createView()));
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
