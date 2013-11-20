<?php

namespace Anytv\DashboardBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Anytv\DashboardBundle\Entity\Country;

class UpdateCountriesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('anytv:update_countries')
            ->setDescription('Updating Countries from Hasoffers to database.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $text = 'Updating Countries from Hasoffers to database.';
        $container = $this->getContainer();
        $doctrine = $container->get('doctrine');
        $repository = $doctrine->getRepository('AnytvDashboardBundle:Country');
        $manager = $doctrine->getManager();
          
        $hasoffers = $container->get('hasoffers');
        $countries_data = $hasoffers->getCountries();
        
        $new_countries = 0;
        $updated_countries = 0;
        foreach($countries_data as $country_data)
        {
          $country_object = $country_data->Country;
          
          $country = $repository->findOneBy(array('code'=>$country_object->code));
          
          if($country)
          {
            $country->setName($country_object->name);
            
            $updated_countries++;
          }
          else
          {
            $country = new Country();
            $country->setCode($country_object->code);
            $country->setName($country_object->name);

            $manager->persist($country);
            
            $new_countries++;
          }
        }

        $manager->flush();
                
        $output->writeln($text);
        $output->writeln($new_countries.' new Countries added.');
        $output->writeln($updated_countries.' Countries updated.');
    }
}
