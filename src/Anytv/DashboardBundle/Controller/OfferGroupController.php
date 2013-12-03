<?php

namespace Anytv\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Anytv\DashboardBundle\Entity\OfferGroup;
use Anytv\DashboardBundle\Form\Type\OfferGroupType;

class OfferGroupController extends Controller
{
    public function indexAction(Request $request, $page)
    {
      $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:OfferGroup');
      $session = $this->get('session');
      $translator = $this->get('translator');
      
      $form = $this->createFormBuilder(array('offer_group_keyword'=>$session->get('offer_group_keyword'), 'offer_group_status'=>$session->get('offer_group_status', 'active')))
        ->add('offer_group_keyword', 'text', array('required'=>false))
        ->add('offer_group_status', 'choice', array('required' => true, 'label'=>$translator->trans('Status'), 'choices' => array('active'=>'active', 'deleted'=>'deleted')))
        ->add('offer_group_search', 'submit', array('label'=>' '))
        //->add('offer_group_update', 'submit', array('label'=>$translator->trans('update')))
        ->getForm();
        
      $form->handleRequest($request);
      
      if($form->isValid()) 
      {
        if($form->get('offer_group_search')->isClicked())
        {
          $data = $form->getData();
          $session->set('offer_group_keyword', $data['offer_group_keyword']); 
          $session->set('offer_group_status', $data['offer_group_status']);  
        }
        else
        {
          $manager = $this->getDoctrine()->getManager();
          
          $hasoffers = $this->get('hasoffers');
          $offer_groups_data = $hasoffers->getOfferGroups();
        
          foreach($offer_groups_data as $offer_group_data)
          {
            $offer_group_data_object = $offer_group_data->OfferGroup;
          
            $offerGroup = $repository->findOneBy(array('offerGroupId'=>$offer_group_data_object->id));
          
            if($offerGroup)
            {
              $offerGroup->setName($offer_group_data_object->name);
              $offerGroup->setStatus($offer_group_data_object->status);
              $offerGroup->setOfferCount($offer_group_data_object->offer_count);
            }
            else
            {
              $offerGroup = new OfferGroup();
              $offerGroup->setOfferGroupId($offer_group_data_object->id);
              $offerGroup->setName($offer_group_data_object->name);
              $offerGroup->setStatus($offer_group_data_object->status);
              $offerGroup->setOfferCount($offer_group_data_object->offer_count);

              $manager->persist($offerGroup);   
            }
          }

          $manager->flush();
          
          return $this->redirect($this->generateUrl('offer_groups_reset'));    
        }
     
        
        
      }
          
      $items_per_page = 30;
      $order_by = 'name';
      $order = 'ASC';
        
      $offer_groups = $repository->findAllOfferGroups($page, $items_per_page, $order_by, $order, $session->get('offer_group_keyword', null), $session->get('offer_group_status', 'active'));
      $total_offer_groups = $repository->countAllOfferGroups($session->get('offer_group_keyword', null), $session->get('offer_group_status', 'active'));
      $total_pages = ceil($total_offer_groups / $items_per_page);
        
      return $this->render('AnytvDashboardBundle:OfferGroup:index.html.twig', array('title'=>$translator->trans('Offer Groups'), 'offer_groups'=>$offer_groups, 'total_offer_groups'=>$total_offer_groups, 'page'=>$page, 'total_pages'=>$total_pages, 'form'=>$form->createView()));
    }
    
    public function resetAction()
    {
        $session = $this->get('session');
        $session->set('offer_group_keyword', null);
        $session->set('offer_group_status', 'active');
        
        return $this->redirect($this->generateUrl('offer_groups'));
    }
     
    public function viewAction($id)
    {
      $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:OfferGroup');
      $translator = $this->get('translator');
      
      $offer_group = $repository->find($id);

      if (!$offer_group) {
        throw $this->createNotFoundException(
            'No offer group found for id '.$id
        );
      }
      
      $offers = $offer_group->getOffers();

      return $this->render('AnytvDashboardBundle:OfferGroup:view.html.twig', array('title'=>$offer_group, 'offer_group'=>$offer_group, 'offer_group_status'=>$translator->trans($offer_group->getStatus()), 'offers'=>$offers));
    }
    
    public function editAction(Request $request, $id)
    {
      $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:OfferGroup');
      $translator = $this->get('translator');
      
      $offer_group = $repository->find($id);

      if (!$offer_group) {
        throw $this->createNotFoundException(
            'No offer group found for id '.$id
        );
      }

      $form = $this->createForm(new OfferGroupType(), $offer_group);

      $form->handleRequest($request);

      if ($form->isValid()) {
        
        $offer_group = $form->getData();
        
        $em = $this->getDoctrine()->getManager();
        
        $em->persist($offer_group);
        $em->flush();

        return $this->redirect($this->generateUrl('offer_group_view', array('id'=>$offer_group->getId())));
      }

      return $this->render('AnytvDashboardBundle:OfferGroup:edit.html.twig', array('title'=>$offer_group, 'form'=>$form->createView(), 'offer_group'=>$offer_group, 'offer_group_status'=>$translator->trans($offer_group->getStatus())));
    }
}
