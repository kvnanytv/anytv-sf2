<?php

namespace Anytv\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        //throw new \Exception('test 500');
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
        $repository = $this->getDoctrine()->getRepository('AnytvMainBundle:Page');
      
      $page = $repository->findOneBy(array('pageKey'=>'upload'));

      if (!$page) {
        throw $this->createNotFoundException(
            'No page found'
        );
      }
      
        $translator = $this->get('translator');
        
        $page_content = $page->getContent($request->get('_locale', 'en'));
        
        return $this->render('AnytvMainBundle:Default:upload.html.twig', array('title'=>$translator->trans($page->getTitle()), 'page'=>$page, 'page_content'=>$page_content));
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
    
    public function joinOurTwitchTeam2Action(Request $request)
    {
      return $this->redirect($this->generateUrl('join_our_twitch_team', array('_locale'=>$request->get('_locale', 'en'))));       
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
    
    public function faqCategoryAction(Request $request, $id = null)
    {
        $faq_category_repository = $this->getDoctrine()->getRepository('AnytvMainBundle:FaqCategory');
        $faq_repository = $this->getDoctrine()->getRepository('AnytvMainBundle:Faq');
        
        $route_params = $request->get('_route_params');
        $locale = $route_params['_locale'];
      
        $selected_faq_category = null;
        if($id)
        {
          $selected_faq_category = $faq_category_repository->find($id);
        }
  
        if ($selected_faq_category) 
        {
          $faqs = $selected_faq_category->getFaqsByLocale($locale);
        }
        else
        {
          switch($locale)
          {
            case 'en':
              $faqs = $faq_repository->findBy(array('isActive'=>true, 'isVisibleEn'=>true));
              break;
            case 'zh':
              $faqs = $faq_repository->findBy(array('isActive'=>true, 'isVisibleZh'=>true));
              break;
            case 'nl':
              $faqs = $faq_repository->findBy(array('isActive'=>true, 'isVisibleNl'=>true));
              break;
            case 'de':
              $faqs = $faq_repository->findBy(array('isActive'=>true, 'isVisibleDe'=>true));
              break;
          }
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
    
    public function transMenuAction($request)
    {
      $route = $request->get('_route'); 
      $route_params = $request->get('_route_params');
      
      $route_params_en = $route_params;
      $route_params_en['_locale'] = 'en';
      $route_params_zh = $route_params;
      $route_params_zh['_locale'] = 'zh';
      $route_params_nl = $route_params;
      $route_params_nl['_locale'] = 'nl';
      $route_params_de = $route_params;
      $route_params_de['_locale'] = 'de';
        
      return $this->render('AnytvMainBundle:Default:transMenu.html.twig', array('route'=>$route, 'route_params'=>$route_params, 'route_params_en'=>$route_params_en, 'route_params_zh'=>$route_params_zh, 'route_params_nl'=>$route_params_nl, 'route_params_de'=>$route_params_de));
    }
    
    
}
