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
    
    public function gamestmAction(Request $request)
    {
      return $this->redirect('http://www.games.tm/');     
    }
    
    public function cyaAction(Request $request)
    {
      return $this->redirect('http://stefansundin.com/stuff/youtube/youtube-copy-annotations.html');     
    }
    
    public function heartbeatAction(Request $request)
    {
      return $this->redirect('http://www.heartbeat.tm/');     
    }
    
    public function uploadAction(Request $request)
    {
      $translator = $this->get('translator');
      
      return $this->render('AnytvMainBundle:Default:upload.html.twig', array('title'=>$translator->trans('Get paid $5 per video submitted to any.TV!'))); 
    }
    
    public function emotionvfxAction(Request $request)
    {
      return $this->render('AnytvMainBundle:Default:emotionvfx.html.twig', array('title'=>'EmotionVFX')); 
    }
    
    public function aboutAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('AnytvMainBundle:Page');
      
      $page = $repository->findOneBy(array('pageKey'=>'about_anytv'));

      if (!$page) {
        throw $this->createNotFoundException(
            'No page found'
        );
      }
      
        $translator = $this->get('translator');
        
        $page_content = $page->getContent($request->get('_locale', 'en'));
        
        return $this->render('AnytvMainBundle:Default:about.html.twig', array('title'=>$translator->trans($page->getTitle()), 'page'=>$page, 'page_content'=>$page_content));
    }
    
    public function brandingKitAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('AnytvMainBundle:Page');
      
      $page = $repository->findOneBy(array('pageKey'=>'branding_kit'));

      if (!$page) {
        throw $this->createNotFoundException(
            'No page found'
        );
      }
      
        $translator = $this->get('translator');
        
        $page_content = $page->getContent($request->get('_locale', 'en'));
        
        return $this->render('AnytvMainBundle:Default:brandingKit.html.twig', array('title'=>$translator->trans($page->getTitle()), 'page'=>$page, 'page_content'=>$page_content));
    }
    
    public function liveStreamHandbookAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('AnytvMainBundle:Page');
      
      $page = $repository->findOneBy(array('pageKey'=>'live_stream_handbook'));

      if (!$page) {
        throw $this->createNotFoundException(
            'No page found'
        );
      }
      
        $translator = $this->get('translator');
        
        $page_content = $page->getContent($request->get('_locale', 'en'));
        
        return $this->render('AnytvMainBundle:Default:liveStreamHandbook.html.twig', array('title'=>$translator->trans($page->getTitle()), 'page'=>$page, 'page_content'=>$page_content));
    }
    
    public function recruiterHandbookAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('AnytvMainBundle:Page');
      
      $page = $repository->findOneBy(array('pageKey'=>'recruiter_handbook'));

      if (!$page) {
        throw $this->createNotFoundException(
            'No page found'
        );
      }
      
        $translator = $this->get('translator');
        
        $page_content = $page->getContent($request->get('_locale', 'en'));
        
        return $this->render('AnytvMainBundle:Default:recruiterHandbook.html.twig', array('title'=>$translator->trans($page->getTitle()), 'page'=>$page, 'page_content'=>$page_content));
    }
    
    public function joinOurTwitchTeamAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('AnytvMainBundle:Page');
      
      $page = $repository->findOneBy(array('pageKey'=>'join_our_twitch_team'));

      if (!$page) {
        throw $this->createNotFoundException(
            'No page found'
        );
      }
      
        $translator = $this->get('translator');
        
        $page_content = $page->getContent($request->get('_locale', 'en'));
        
        return $this->render('AnytvMainBundle:Default:joinOurTwitchTeam.html.twig', array('title'=>$translator->trans($page->getTitle()), 'page'=>$page, 'page_content'=>$page_content));
    }
    
    public function staffAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('AnytvMainBundle:Page');
      
      $page = $repository->findOneBy(array('pageKey'=>'staff'));

      if (!$page) {
        throw $this->createNotFoundException(
            'No page found'
        );
      }
      
        $translator = $this->get('translator');
        
        $page_content = $page->getContent($request->get('_locale', 'en'));
        
        return $this->render('AnytvMainBundle:Default:staff.html.twig', array('title'=>$translator->trans($page->getTitle()), 'page'=>$page, 'page_content'=>$page_content));
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
        $repository = $this->getDoctrine()->getRepository('AnytvMainBundle:Page');
      
      $page = $repository->findOneBy(array('pageKey'=>'faq_spreadsheet'));

      if (!$page) {
        throw $this->createNotFoundException(
            'No page found'
        );
      }
      
        $translator = $this->get('translator');
        
        $page_content = $page->getContent($request->get('_locale', 'en'));
        
        return $this->render('AnytvMainBundle:Default:faqSpreadsheet.html.twig', array('title'=>$translator->trans($page->getTitle()), 'page'=>$page, 'page_content'=>$page_content));
    }
    
    
    
    
}
