<?php

namespace Anytv\DashboardBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Anytv\DashboardBundle\Entity\TrafficReferral;

class UpdateTrafficReferralsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('anytv:update_traffic_referrals')
            ->setDescription('Updating TrafficReferrals from Hasoffers to database.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $text = 'Updating TrafficReferrals from Hasoffers to database.';
        $container = $this->getContainer();
        $doctrine = $container->get('doctrine');
        $repository = $doctrine->getRepository('AnytvDashboardBundle:TrafficReferral');
        $affiliate_repository = $doctrine->getRepository('AnytvDashboardBundle:Affiliate');
        $offer_repository = $doctrine->getRepository('AnytvDashboardBundle:Offer');
        $manager = $doctrine->getManager();
        
        $max_traffic_referral_date = $repository->getMaxTrafficReferralDate();
          
        $hasoffers = $container->get('hasoffers');
        $traffic_referrals_data = $hasoffers->getTrafficReferrals($max_traffic_referral_date);
        
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
          
          $traffic_referral = null;
          if($affiliate && $offer)
          {
            $traffic_referral = $repository->findOneBy(array('affiliate'=>$affiliate, 'offer'=>$offer, 'url'=>$traffic_referral_stat_object->url, 'statDate'=>new \DateTime($traffic_referral_stat_object->date)));
          }
          
          if($traffic_referral)
          {
            $traffic_referral->setCount($traffic_referral_stat_object->count);
            $traffic_referral->setClicks($traffic_referral_stat_object->clicks);
            $traffic_referral->setConversions($traffic_referral_stat_object->conversions);
          }
          else
          {
            $traffic_referral = new TrafficReferral();
          
            if($affiliate)
            {
              $traffic_referral->setAffiliate($affiliate);      
            }
          
            if($offer)
            {
              $traffic_referral->setOffer($offer);      
            }
          
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
                
        $output->writeln($text);
        $output->writeln($new_traffic_referrals.' new TrafficReferrals added.');
    }
}
