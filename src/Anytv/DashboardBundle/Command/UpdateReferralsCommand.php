<?php

namespace Anytv\DashboardBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Anytv\DashboardBundle\Entity\Referral;

class UpdateReferralsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('anytv:update_referrals')
            ->setDescription('Updating Referrals from Hasoffers to database.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $text = 'Updating Referrals from Hasoffers to database.';
        $container = $this->getContainer();
        $doctrine = $container->get('doctrine');
        $repository = $doctrine->getRepository('AnytvDashboardBundle:Referral');
        $affiliate_repository = $doctrine->getRepository('AnytvDashboardBundle:Affiliate');
        $manager = $doctrine->getManager();
        
        $max_referral_date = $repository->getMaxReferralDate();
          
        $hasoffers = $container->get('hasoffers');
        $referrals_data = $hasoffers->getReferrals($max_referral_date);
        
        $new_referrals = 0;
        foreach($referrals_data as $referral_data)
        {
          $referral_object = $referral_data->Stat;
              
          $referrer = $affiliate_repository->findOneBy(array('affiliateId'=>$referral_object->referral_id));
          $referred = $affiliate_repository->findOneBy(array('affiliateId'=>$referral_object->affiliate_id));
          $date = new \DateTime($referral_object->date);
          $amount = $referral_object->amount;
              
          if($referrer && $referred)
          {
            if($referral = $repository->findOneBy(array('referrer'=>$referrer, 'referred'=>$referred, 'date'=>$date)))
            {
              $referral->setAmount($amount);    
            }
            else
            {
              $referral = new Referral();
              $referral->setReferrer($referrer);
              $referral->setReferred($referred);
              $referral->setAmount($amount);
              $referral->setDate($date);
                  
              $manager->persist($referral);
              
              $new_referrals++;
            }
          }
        }

        $manager->flush();
                
        $output->writeln($text);
        $output->writeln($new_referrals.' new Referrals added.');
    }
}
