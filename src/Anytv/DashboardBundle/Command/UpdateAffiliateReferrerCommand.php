<?php

namespace Anytv\DashboardBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Anytv\DashboardBundle\Entity\Affiliate;

class UpdateAffiliateReferrerCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('anytv:update_affiliate_referrer')
            ->setDescription('Updating Affiliate Referrers.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $text = 'Updating Affiliate Referrers.';
        $container = $this->getContainer();
        $doctrine = $container->get('doctrine');
        $repository = $doctrine->getRepository('AnytvDashboardBundle:Affiliate');
   
        $manager = $doctrine->getManager();
        
        $referrer_count = 0;
        $referrer_request_batch = 300;
            
        $affiliates_wo_referrers = $repository->findBy(array('referrerRequested'=>false), null, $referrer_request_batch);
            
        if($affiliates_wo_referrers)
        {
          foreach($affiliates_wo_referrers as $affiliate)
          {
            if($affiliate->getReferralId() && ($referrer = $repository->findOneBy(array('affiliateId'=>$affiliate->getReferralId()))))
            {
              $affiliate->setReferrer($referrer);
              $referrer_count++;
            }
                
            $affiliate->setReferrerRequested(true);   
          }
            
          $manager->flush(); 
        }
                
        $output->writeln($text);
        $output->writeln($referrer_count.' Referrers set.');
    }
}
