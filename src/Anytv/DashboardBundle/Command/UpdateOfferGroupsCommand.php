<?php

namespace Anytv\DashboardBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Anytv\DashboardBundle\Entity\OfferGroup;

class UpdateOfferGroupsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('anytv:update_offer_groups')
            ->setDescription('Updating OfferGroups from Hasoffers to database.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $text = 'Updating OfferGroups from Hasoffers to database.';
        $container = $this->getContainer();
        $doctrine = $container->get('doctrine');
        $repository = $doctrine->getRepository('AnytvDashboardBundle:OfferGroup');
        $manager = $doctrine->getManager();
          
        $hasoffers = $container->get('hasoffers');
        $offer_groups_data = $hasoffers->getOfferGroups();
        
        $new_offer_groups = 0;
        $updated_offer_groups = 0;
        foreach($offer_groups_data as $offer_group_data)
        {
          $offer_group_data_object = $offer_group_data->OfferGroup;
          
          $offerGroup = $repository->findOneBy(array('offerGroupId'=>$offer_group_data_object->id));
          
          if($offerGroup)
          {
            $offerGroup->setName($offer_group_data_object->name);
            $offerGroup->setStatus($offer_group_data_object->status);
            $offerGroup->setOfferCount($offer_group_data_object->offer_count);
            $updated_offer_groups++;
          }
          else
          {
            $offerGroup = new OfferGroup();
            $offerGroup->setOfferGroupId($offer_group_data_object->id);
            $offerGroup->setName($offer_group_data_object->name);
            $offerGroup->setStatus($offer_group_data_object->status);
            $offerGroup->setOfferCount($offer_group_data_object->offer_count);

            $manager->persist($offerGroup);
            $new_offer_groups++;
          }
        }

        $manager->flush();
                
        $output->writeln($text);
        $output->writeln($new_offer_groups.' new OfferGroups added.');
        $output->writeln($updated_offer_groups.' OfferGroups updated.');
    }
}
