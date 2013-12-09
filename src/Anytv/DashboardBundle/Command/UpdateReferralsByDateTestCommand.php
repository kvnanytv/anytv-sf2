<?php

namespace Anytv\DashboardBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Anytv\DashboardBundle\Entity\Referral;

class UpdateReferralsByDateTestCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('anytv:update_referrals_by_date_test')
            ->setDescription('Updating Referrals by date (test) from Hasoffers to database.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        set_time_limit(0);
        $text = 'Updating Referrals by date (test) from Hasoffers to database.';
        $container = $this->getContainer();
        $doctrine = $container->get('doctrine');
        $repository = $doctrine->getRepository('AnytvDashboardBundle:Referral');
        $affiliate_repository = $doctrine->getRepository('AnytvDashboardBundle:Affiliate');
        $manager = $doctrine->getManager();
        $hasoffers = $container->get('hasoffers');
        
        $max_referral_date = $repository->getMaxReferralDate();
        
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime($today.' -1 day'));
        
        $ctr = 0;
        while($max_referral_date != $yesterday)
        {
          if($max_referral_date)
          {
            $referral_date = new \DateTime(date('Y-m-d', strtotime($max_referral_date.' +1 day')));    
          }
          else
          {
            $referral_date = new \DateTime(date('Y-m-d', strtotime('2013-02-11')));   
          }  
          
          $referrals_data = $hasoffers->getReferralsByDate($referral_date);
        
          $new_referrals = 0;
          foreach($referrals_data as $referral_data)
          {
            $referral_object = $referral_data->Stat;
              
            $referrer = $affiliate_repository->findOneBy(array('affiliateId'=>$referral_object->referral_id));
            $referred = $affiliate_repository->findOneBy(array('affiliateId'=>$referral_object->affiliate_id));
            $date = new \DateTime($referral_object->date);
            $amount = $referral_object->amount;
            $total = $referral_object->var_total;
              
            if($referrer && $referred)
            {
              $referral = new Referral();
              $referral->setReferrer($referrer);
              $referral->setReferred($referred);
              $referral->setAmount($amount);
              $referral->setTotal($total);
              $referral->setDate($date);
                  
              $manager->persist($referral);
              
              $new_referrals++;
            
            }
          }
          
          $manager->flush();
                
          $output->writeln($text.' '.date_format($referral_date, 'Y-m-d'));
          $output->writeln($new_referrals.' new Referrals added.');
          
          $max_referral_date = $repository->getMaxReferralDate();
          
          $ctr++;
          
          if($ctr==30)
          {
              break;
          }
        }
    }
}
