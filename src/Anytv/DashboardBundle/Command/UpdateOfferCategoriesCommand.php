<?php

namespace Anytv\DashboardBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Anytv\DashboardBundle\Entity\OfferCategory;

class UpdateOfferCategoriesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('anytv:update_offer_categories')
            ->setDescription('Updating OfferCategories from Hasoffers to database.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $text = 'Updating OfferCategories from Hasoffers to database.';
        $container = $this->getContainer();
        $doctrine = $container->get('doctrine');
        $repository = $doctrine->getRepository('AnytvDashboardBundle:OfferCategory');
        $manager = $doctrine->getManager();
          
        $hasoffers = $container->get('hasoffers');
        $offer_categories_data = $hasoffers->getOfferCategories();
        
        $new_offer_categories = 0;
        $updated_offer_categories = 0;
        foreach($offer_categories_data as $offer_category_data)
        {
          $offer_category_object = $offer_category_data->OfferCategory;
          
          $offer_category = $repository->findOneBy(array('offerCategoryId'=>$offer_category_object->id));
          
          if($offer_category)
          {
            $offer_category->setName($offer_category_object->name);
            $offer_category->setStatus($offer_category_object->status);
            $offer_category->setOfferCount($offer_category_object->offer_count);
            $updated_offer_categories++;
          }
          else
          {
            $offer_category = new OfferCategory();
            $offer_category->setOfferCategoryId($offer_category_object->id);
            $offer_category->setName($offer_category_object->name);
            $offer_category->setStatus($offer_category_object->status);
            $offer_category->setOfferCount($offer_category_object->offer_count);

            $manager->persist($offer_category);
            $new_offer_categories++;
          }
        }

        $manager->flush();
                
        $output->writeln($text);
        $output->writeln($new_offer_categories.' new OfferCategories added.');
        $output->writeln($updated_offer_categories.' OfferCategories updated.');
    }
}
