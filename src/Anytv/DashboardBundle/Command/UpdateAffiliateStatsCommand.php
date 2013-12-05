<?php

namespace Anytv\DashboardBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Anytv\DashboardBundle\Entity\TrafficReferral;
use Anytv\DashboardBundle\Entity\Affiliate;

class UpdateAffiliateStatsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('anytv:update_affiliate_stats')
            ->setDescription('Updating AffiliateStats from Traffic Referrals.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $text = 'Updating AffiliateStats from Traffic Referrals.';
        $container = $this->getContainer();
        $doctrine = $container->get('doctrine');
        $repository = $doctrine->getRepository('AnytvDashboardBundle:Affiliate');
        $traffic_referral_repository = $doctrine->getRepository('AnytvDashboardBundle:TrafficReferral');
        $manager = $doctrine->getManager();
          
        $traffic_referrals = $traffic_referral_repository->findBy(array('affiliateStatsRequested'=>false), null, 10000);
        
        $updated_affiliate_stats = 0;
        foreach($traffic_referrals as $traffic_referral)
        {   
          $affiliate = $traffic_referral->getAffiliate();
          
          if($affiliate)
          {
            $affiliate->setClicks($affiliate->getClicks() + $traffic_referral->getClicks());
            $affiliate->setConversionCount($affiliate->getConversionCount() + $traffic_referral->getConversions());
    
            $updated_affiliate_stats++;  
              
          }
          
          $traffic_referral->setAffiliateStatsRequested(true);
        }
        
        $manager->flush();
                
        $output->writeln($text);
        $output->writeln($updated_affiliate_stats.' Affiliates updated.');
    }
}
