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
      
}