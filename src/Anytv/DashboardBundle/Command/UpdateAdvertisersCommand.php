<?php

namespace Anytv\DashboardBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Anytv\DashboardBundle\Entity\Advertiser;

class UpdateAdvertisersCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('anytv:update_advertisers')
            ->setDescription('Updating Advertisers from Hasoffers to database.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $text = 'Updating Advertisers from Hasoffers to database.';
        $container = $this->getContainer();
        $doctrine = $container->get('doctrine');
        $repository = $doctrine->getRepository('AnytvDashboardBundle:Advertiser');
        $country_repository = $doctrine->getRepository('AnytvDashboardBundle:Country');
        $manager = $doctrine->getManager();
          
        $hasoffers = $container->get('hasoffers');
        $advertisers_data = $hasoffers->getAdvertisers();
        
        $new_advertisers = 0;
        $updated_advertisers = 0;
        
        foreach($advertisers_data as $advertiser_data)
        {
          $advertiser_object = $advertiser_data->Advertiser;
            
          $advertiser = $repository->findOneBy(array('advertiserId'=>$advertiser_object->id));
          
          if($advertiser)
          {
            $advertiser->setCompany($advertiser_object->company);
            $advertiser->setStatus($advertiser_object->status);
            $advertiser->setAddress1($advertiser_object->address1);
            $advertiser->setAddress2($advertiser_object->address2);
            $advertiser->setCity($advertiser_object->city);
            $advertiser->setRegion($advertiser_object->region);
          
            if($country = $country_repository->findOneByCode($advertiser_object->country))
            {
              $advertiser->setCountry($country);         
            } 
          
            $advertiser->setOther($advertiser_object->other);
            $advertiser->setZipcode($advertiser_object->zipcode);
            $advertiser->setPhone($advertiser_object->phone);
            $advertiser->setFax($advertiser_object->fax);
            $advertiser->setWebsite($advertiser_object->website);
            $advertiser->setWantsAlerts($advertiser_object->wants_alerts);
            $advertiser->setAccountManagerId($advertiser_object->account_manager_id);
            $advertiser->setSignupIp($advertiser_object->signup_ip);
            $advertiser->setRefId($advertiser_object->ref_id);
            $advertiser->setCreatedAt(new \DateTime($advertiser_object->date_added));
            $advertiser->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s', $advertiser_object->modified)));
            
            $updated_advertisers++;
          }
          else
          {
            $advertiser = new Advertiser();
            $advertiser->setAdvertiserId($advertiser_object->id);
            $advertiser->setCompany($advertiser_object->company);
            $advertiser->setStatus($advertiser_object->status);
            $advertiser->setAddress1($advertiser_object->address1);
            $advertiser->setAddress2($advertiser_object->address2);
            $advertiser->setCity($advertiser_object->city);
            $advertiser->setRegion($advertiser_object->region);
          
            if($country = $country_repository->findOneByCode($advertiser_object->country))
            {
              $advertiser->setCountry($country);         
            } 
          
            $advertiser->setOther($advertiser_object->other);
            $advertiser->setZipcode($advertiser_object->zipcode);
            $advertiser->setPhone($advertiser_object->phone);
            $advertiser->setFax($advertiser_object->fax);
            $advertiser->setWebsite($advertiser_object->website);
            $advertiser->setWantsAlerts($advertiser_object->wants_alerts);
            $advertiser->setAccountManagerId($advertiser_object->account_manager_id);
            $advertiser->setSignupIp($advertiser_object->signup_ip);
            $advertiser->setRefId($advertiser_object->ref_id);
            $advertiser->setCreatedAt(new \DateTime($advertiser_object->date_added));
            $advertiser->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s', $advertiser_object->modified)));

            $manager->persist($advertiser);  
            
            $new_advertisers++;
          }
        }

        $manager->flush();
                
        $output->writeln($text);
        $output->writeln($new_advertisers.' new Advertisers added.');
        $output->writeln($updated_advertisers.' Advertisers updated.');
    }
}
