<?php

namespace Anytv\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Anytv\DashboardBundle\Entity\AffiliateUser;
use Anytv\DashboardBundle\Form\Type\AffiliateUserType;

class AffiliateUserController extends Controller
{
   public function viewAction($id)
    {
      $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:AffiliateUser');
      
      $affiliate_user = $repository->find($id);

      if (!$affiliate_user) {
        throw $this->createNotFoundException(
            'No affiliate user found for id '.$id
        );
      }
      
      $affiliate = $affiliate_user->getAffiliate();

      return $this->render('AnytvDashboardBundle:AffiliateUser:view.html.twig', array('title'=>$affiliate_user, 'affiliate_user'=>$affiliate_user, 'affiliate'=>$affiliate));
    }   
    
    public function editAction(Request $request, $id)
    {
      $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:AffiliateUser');
      
      $affiliate_user = $repository->find($id);

      if (!$affiliate_user) {
        throw $this->createNotFoundException(
            'No affiliate user found for id '.$id
        );
      }

      $form = $this->createForm(new AffiliateUserType(), $affiliate_user);

      $form->handleRequest($request);

      if ($form->isValid()) {
        
        $affiliate_user = $form->getData();
        
        $em = $this->getDoctrine()->getManager();
        
        $em->persist($affiliate_user);
        $em->flush();

        return $this->redirect($this->generateUrl('affiliate_user_view', array('id'=>$affiliate_user->getId())));
      }
      
      $affiliate = $affiliate_user->getAffiliate();

      return $this->render('AnytvDashboardBundle:AffiliateUser:edit.html.twig', array('title'=>'Edit '.$affiliate_user, 'form'=>$form->createView(), 'affiliate_user'=>$affiliate_user, 'affiliate'=>$affiliate));
    }
}