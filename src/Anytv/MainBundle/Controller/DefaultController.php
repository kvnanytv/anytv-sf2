<?php

namespace Anytv\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Anytv\MainBundle\Entity\FaqCategory;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        
        // rendering different formats of same resource
        //$format = $this->getRequest()->getRequestFormat();
        //return $this->render('AnytvMainBundle:Default:index.'.$format.'.twig');
    
        return $this->render('AnytvMainBundle:Default:index.html.twig');
    }
    
    public function aboutAction(Request $request)
    {
        return $this->render('AnytvMainBundle:Default:about.html.twig', array('title'=>'About'));
    }
    
    public function brandingKitAction(Request $request)
    {
        return $this->render('AnytvMainBundle:Default:brandingKit.html.twig', array('title'=>'Branding Kit'));
    }
    
    public function liveStreamHandbookAction(Request $request)
    {
        return $this->render('AnytvMainBundle:Default:liveStreamHandbook.html.twig', array('title'=>'Live Stream Handbook'));
    }
    
    public function recruiterHandbookAction(Request $request)
    {
        return $this->render('AnytvMainBundle:Default:recruiterHandbook.html.twig', array('title'=>'Recruiter Handbook'));
    }
    
    public function joinOurTwitchTeamAction(Request $request)
    {
        return $this->render('AnytvMainBundle:Default:joinOurTwitchTeam.html.twig', array('title'=>'Join Our Twitch Team'));
    }
    
    public function staffAction(Request $request)
    {
        return $this->render('AnytvMainBundle:Default:staff.html.twig', array('title'=>'Staff'));
    }
    
    public function faqAction(Request $request)
    {
        $translator = $this->get('translator');
        
        return $this->render('AnytvMainBundle:Default:faq.html.twig', array('title'=>$translator->trans('FAQ')));
    }
    
    public function faqCategoryAction($id = null)
    {
        $faq_category_repository = $this->getDoctrine()->getRepository('AnytvMainBundle:FaqCategory');
        $faq_repository = $this->getDoctrine()->getRepository('AnytvMainBundle:Faq');
        
        $faq_categories = $faq_category_repository->findAll();
        
        $selected_faq_category = null;
        if($id)
        {
          $selected_faq_category = $faq_category_repository->find($id);
        }
  
        if ($selected_faq_category) 
        {
          $faqs = $selected_faq_category->getFaqs();
        }
        else
        {
          $faqs = $faq_repository->findAll();
        }
        
       
        return $this->render('AnytvMainBundle:Default:faqCategory.html.twig', array('faq_categories'=>$faq_categories, 'selected_faq_category'=>$selected_faq_category, 'faqs'=>$faqs));
    }
    
    public function faqSpreadsheetAction(Request $request)
    {
        return $this->render('AnytvMainBundle:Default:faqSpreadsheet.html.twig', array('title'=>'FAQ Spreadsheet'));
    }
    
    public function signupAction(Request $request)
    {
        return $this->render('AnytvMainBundle:Default:signup.html.twig', array('title'=>'Affiliate Sign Up'));
    }
    
    
}
