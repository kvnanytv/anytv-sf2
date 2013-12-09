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
    
    public function videoGraphAction($id)
    {
      $repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:YoutubeVideo');
      $traffic_referral_repository = $this->getDoctrine()->getRepository('AnytvDashboardBundle:TrafficReferral');
      
      $video = $repository->find($id);

      if (!$video) {
        throw $this->createNotFoundException(
            'No video found for id '.$id
        );
      }
      
      $affiliate_user = $this->getUser();
   
      if (!$affiliate_user) {
        throw $this->createNotFoundException(
            'No user found'
        );
      }
      
      $affiliate = $affiliate_user->getAffiliate();
      
      if (!$affiliate) {
        throw $this->createNotFoundException(
            'No affiliate found'
        );
      }
      
      $order_by = 'id';
      $graph_order = 'ASC';

      $graph_referrals = $traffic_referral_repository->findAllTrafficReferralsForVideoGraph($order_by, $graph_order, $video->getAffiliate(), $video->getOffer(), $video->getUrl());
      
      $strDateFrom = date_format($video->getFirstStatDate(), 'Y-m-d');
      $strDateTo = date('Y-m-d');
      
      $aryRange = array();

      $iDateFrom = mktime(1, 0, 0, substr($strDateFrom,5,2), substr($strDateFrom,8,2),substr($strDateFrom,0,4));
      $iDateTo = mktime(1, 0, 0, substr($strDateTo,5,2), substr($strDateTo,8,2),substr($strDateTo,0,4));

      if ($iDateTo >= $iDateFrom)
      {
        $aryRange[date('Y-m-d', $iDateFrom)] = 0;
        while ($iDateFrom < $iDateTo)
        {
            $iDateFrom += 86400;
            $aryRange[date('Y-m-d', $iDateFrom)] = 0;
        }
      }
      
      $max_clicks = 0;
      foreach($graph_referrals as $graph_referral)
      {
        $aryRange[$graph_referral->getDateAsString()] += $graph_referral->getClicks(); 
        
        if($aryRange[$graph_referral->getDateAsString()] > $max_clicks)
        {
          $max_clicks = $aryRange[$graph_referral->getDateAsString()];        
        }
      }
      
      return $this->render('AnytvDashboardBundle:YoutubeVideo:videoGraph.html.twig', array('video'=>$video, 'aryRange'=>$aryRange, 'max_clicks'=>$max_clicks));
    }
}
