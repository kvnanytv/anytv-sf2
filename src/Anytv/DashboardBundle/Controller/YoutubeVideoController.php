<?php

namespace Anytv\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
//use Anytv\DashboardBundle\Entity\YoutubeVideo;
//use Anytv\DashboardBundle\Entity\Affiliate;
//use Anytv\DashboardBundle\Entity\Offer;

class YoutubeVideoController extends Controller
{
    public function listYoutubeVideosByAffiliateAction($affiliate_id, $page)
    { 
      $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:YoutubeVideo');
      $affiliate_repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:Affiliate');
      
      $items_per_page = 10;
      $order_by = 'clicks';
      $order_by_2 = 'conversions';
      $order = 'DESC';
      $affiliate = $affiliate_repository->find($affiliate_id);
        
      $youtube_videos = $repository->findAllYoutubeVideosFiltered($page, $items_per_page, $order_by, $order_by_2, $order, $affiliate, true);
      $total_youtube_videos = $repository->countAllYoutubeVideosFiltered($affiliate);
      $total_pages = ceil($total_youtube_videos / $items_per_page);
      
      return $this->render('AnytvDashboardBundle:YoutubeVideo:listYoutubeVideosByAffiliate.html.twig', array('youtube_videos'=>$youtube_videos, 'total_youtube_videos'=>$total_youtube_videos, 'page'=>$page, 'total_pages'=>$total_pages, 'affiliate_id'=>$affiliate_id));
    }
}
