<?php

namespace Anytv\DashboardBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Anytv\DashboardBundle\Entity\TrafficReferral;

class UpdateTrafficReferralsByDateTestCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('anytv:update_traffic_referrals_by_date_test')
            ->setDescription('Updating TrafficReferrals by date (test) from Hasoffers to database.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $text = 'Updating TrafficReferrals by date (test) from Hasoffers to database.';
        $container = $this->getContainer();
        $doctrine = $container->get('doctrine');
        $repository = $doctrine->getRepository('AnytvDashboardBundle:TrafficReferral');
        $affiliate_repository = $doctrine->getRepository('AnytvDashboardBundle:Affiliate');
        $offer_repository = $doctrine->getRepository('AnytvDashboardBundle:Offer');
        $manager = $doctrine->getManager();
        $hasoffers = $container->get('hasoffers');
        
        $max_traffic_referral_date = $repository->getMaxTrafficReferralDate();
        
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime($today.' -1 day'));
        
        $ctr = 0;
        
        while($max_traffic_referral_date != $yesterday)
        {
          if($max_traffic_referral_date)
          {
            $traffic_referral_date = new \DateTime(date('Y-m-d', strtotime($max_traffic_referral_date.' +1 day')));    
          }
          else
          {
            $traffic_referral_date = new \DateTime(date('Y-m-d', strtotime('2013-01-10')));   
          }
          
          $traffic_referrals_data = $hasoffers->getTrafficReferralsByDate($traffic_referral_date);
        
          $new_traffic_referrals = 0;
          foreach($traffic_referrals_data as $traffic_referral_data)
          {
            $traffic_referral_stat_object = $traffic_referral_data->Stat;
          
            $affiliate = null;
            if($traffic_referral_stat_object->affiliate_id)
            {
              $affiliate = $affiliate_repository->findOneByAffiliateId($traffic_referral_stat_object->affiliate_id);        
            }
          
            $offer = null;
            if($traffic_referral_stat_object->offer_id)
            {
              $offer = $offer_repository->findOneByOfferId($traffic_referral_stat_object->offer_id);    
            }
          
            if($affiliate && $offer)
            {
              $traffic_referral = new TrafficReferral();
              $traffic_referral->setAffiliate($affiliate);      
              $traffic_referral->setOffer($offer);      
              $traffic_referral->setUrl($traffic_referral_stat_object->url);
              $traffic_referral->setClicks($traffic_referral_stat_object->clicks);
              $traffic_referral->setConversions($traffic_referral_stat_object->conversions);
              $traffic_referral->setCount($traffic_referral_stat_object->count);
              $traffic_referral->setStatDate(new \DateTime($traffic_referral_stat_object->date));

              $manager->persist($traffic_referral); 
            
              $new_traffic_referrals++;  
            }
          }

          $manager->flush();
                
          $output->writeln($text.' '.date_format($traffic_referral_date, 'Y-m-d'));
          $output->writeln($new_traffic_referrals.' new TrafficReferrals added.');
          
          $max_traffic_referral_date = $repository->getMaxTrafficReferralDate();
          
          $ctr++;
          
          if($ctr==30)
          {
              break;
          }
        }
    }
}
