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
        $translator = $this->get('translator');
        
        return $this->render('AnytvMainBundle:Default:about.html.twig', array('title'=>$translator->trans('What is any.TV?')));
    }
    
    public function brandingKitAction(Request $request)
    {
        $translator = $this->get('translator');
        
        return $this->render('AnytvMainBundle:Default:brandingKit.html.twig', array('title'=>$translator->trans('Branding Kit')));
    }
    
    public function liveStreamHandbookAction(Request $request)
    {
        $translator = $this->get('translator');
        
        return $this->render('AnytvMainBundle:Default:liveStreamHandbook.html.twig', array('title'=>$translator->trans('Live Stream Handbook')));
    }
    
    public function recruiterHandbookAction(Request $request)
    {
        $translator = $this->get('translator');
        
        return $this->render('AnytvMainBundle:Default:recruiterHandbook.html.twig', array('title'=>$translator->trans('Recruiter Handbook')));
    }
    
    public function joinOurTwitchTeamAction(Request $request)
    {
        $translator = $this->get('translator');
        
        return $this->render('AnytvMainBundle:Default:joinOurTwitchTeam.html.twig', array('title'=>$translator->trans('Join our Twitch Team!')));
    }
    
    public function staffAction(Request $request)
    {
        $translator = $this->get('translator');
        
        return $this->render('AnytvMainBundle:Default:staff.html.twig', array('title'=>$translator->trans('Staff')));
    }
    
    public function faqAction(Request $request)
    {
        $faq_category_repository = $this->getDoctrine()->getRepository('AnytvMainBundle:FaqCategory');
        $translator = $this->get('translator');
        
        $faq_categories = $faq_category_repository->findAll();
        foreach($faq_categories as $faq_category)
        {
          $faq_category->setName($translator->trans($faq_category));
        }
        
        return $this->render('AnytvMainBundle:Default:faq.html.twig', array('title'=>$translator->trans('FAQ'), 'faq_categories'=>$faq_categories));
    }
    
    public function faqCategoryAction($id = null)
    {
        $faq_category_repository = $this->getDoctrine()->getRepository('AnytvMainBundle:FaqCategory');
        $faq_repository = $this->getDoctrine()->getRepository('AnytvMainBundle:Faq');
        
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
        
       
        return $this->render('AnytvMainBundle:Default:faqCategory.html.twig', array('selected_faq_category'=>$selected_faq_category, 'faqs'=>$faqs));
    }
    
    public function faqSpreadsheetAction(Request $request)
    {
        $translator = $this->get('translator');
        
        return $this->render('AnytvMainBundle:Default:faqSpreadsheet.html.twig', array('title'=>$translator->trans('FAQ Spreadsheet')));
    }
    
    
    
    
}
