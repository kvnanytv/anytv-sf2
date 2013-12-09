<?php

namespace Anytv\DashboardBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Anytv\DashboardBundle\Entity\Affiliate;

class UpdateAffiliatePaypalCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('anytv:update_affiliate_paypal')
            ->setDescription('Updating Affiliates Paypal emails from Hasoffers to database.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $text = 'Updating Affiliates Paypal emails from Hasoffers to database.';
        $container = $this->getContainer();
        $doctrine = $container->get('doctrine');
        $repository = $doctrine->getRepository('AnytvDashboardBundle:Affiliate');
        $hasoffers = $container->get('hasoffers');
        $manager = $doctrine->getManager();
        
        $paypal_email_count = 0;
        $paypal_request_batch = 100;
            
        $affiliates_wo_paypal_email = $repository->findBy(array('status'=>'active', 'paypalEmailRequested'=>false), null, $paypal_request_batch);
            
        if($affiliates_wo_paypal_email)
        {
          foreach($affiliates_wo_paypal_email as $affiliate)
          {
            if($paypal_email = $hasoffers->getPaypalEmail($affiliate->getAffiliateId()))
            {
              $affiliate->setPaypalEmail($paypal_email);
              $paypal_email_count++;
            }
                
            $affiliate->setPaypalEmailRequested(true);   
          }
            
          $manager->flush();      
        } 
                
        $output->writeln($text);
        $output->writeln($paypal_email_count.' Paypal emails set.');
    }
}
