<?php

namespace Anytv\DashboardBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Anytv\DashboardBundle\Entity\TrafficReferral;
use Anytv\DashboardBundle\Entity\YoutubeVideo;

class UpdateYoutubeVideosCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('anytv:update_youtube_videos')
            ->setDescription('Updating YoutubeVideos from Traffic Referrals.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $text = 'Updating YoutubeVideos from Traffic Referrals.';
        $container = $this->getContainer();
        $doctrine = $container->get('doctrine');
        $repository = $doctrine->getRepository('AnytvDashboardBundle:YoutubeVideo');
        $traffic_referral_repository = $doctrine->getRepository('AnytvDashboardBundle:TrafficReferral');
        $manager = $doctrine->getManager();
          
        $traffic_referrals = $traffic_referral_repository->findBy(array('youtubeVideoRequested'=>false), null, 10000);
        
        $new_youtube_videos = 0;
        $updated_youtube_videos = 0;
        foreach($traffic_referrals as $traffic_referral)
        {   
          if(substr_count($traffic_referral->getUrl(), 'youtube.com/watch?v='))
          {
            $affiliate = $traffic_referral->getAffiliate();
          
            $offer = $traffic_referral->getOffer();
          
            if($affiliate && $offer)
            {
              $youtube_video = $repository->findOneBy(array('affiliate'=>$affiliate, 'offer'=>$offer, 'url'=>$traffic_referral->getUrl()));
            
              if($youtube_video)
              {
                $youtube_video->setClicks($youtube_video->getClicks() + $traffic_referral->getClicks());
                $youtube_video->setConversions($youtube_video->getConversions() + $traffic_referral->getConversions());
                $youtube_video->setCount($youtube_video->getCount() + 1);
                $youtube_video->setLastStatDate($traffic_referral->getStatDate()); 
              
                $updated_youtube_videos++;
              }
              else
              {
                $youtube_video = new YoutubeVideo();
                $youtube_video->setAffiliate($affiliate);      
                $youtube_video->setOffer($offer);      
                $youtube_video->setUrl($traffic_referral->getUrl());
                $youtube_video->setClicks($traffic_referral->getClicks());
                $youtube_video->setConversions($traffic_referral->getConversions());
                $youtube_video->setLastStatDate($traffic_referral->getStatDate());

                $manager->persist($youtube_video); 
            
                $new_youtube_videos++;  
              }
            }
          }
          $traffic_referral->setYoutubeVideoRequested(true);
        }
        
        $manager->flush();
                
        $output->writeln($text);
        $output->writeln($new_youtube_videos.' new YoutubeVideos added.');
        $output->writeln($updated_youtube_videos.' YoutubeVideos updated.');
    }
}
