<?php

namespace Anytv\DashboardBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Anytv\DashboardBundle\Entity\Offer;

class UpdateOffersCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('anytv:update_offers')
            ->setDescription('Updating Offers from Hasoffers to database.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $text = 'Updating Offers from Hasoffers to database.';
        $container = $this->getContainer();
        $doctrine = $container->get('doctrine');
        $repository = $doctrine->getRepository('AnytvDashboardBundle:Offer');
        $advertiser_repository = $doctrine->getRepository('AnytvDashboardBundle:Advertiser');
        $offer_category_repository = $doctrine->getRepository('AnytvDashboardBundle:OfferCategory');
        $offer_group_repository = $doctrine->getRepository('AnytvDashboardBundle:OfferGroup');
        $country_repository = $doctrine->getRepository('AnytvDashboardBundle:Country');
        $countries = $country_repository->findAll();
        $manager = $doctrine->getManager();
        
        $max_offer_id = $repository->getMaxOfferId();
          
        $hasoffers = $container->get('hasoffers');
        $offers_data = $hasoffers->getOffers($max_offer_id);
        
        $new_offers = 0;
        foreach($offers_data as $offer_data)
        {
          $offer_object = $offer_data->Offer;
          $offer_category_array = $offer_data->OfferCategory;
          $country_array = $offer_data->Country;
          $offer_group_array = $offer_data->OfferGroup;
          
          $offer = new Offer();
          $offer->setOfferId($offer_object->id);
          $offer->setName($offer_object->name);
          $offer->setDescription($offer_object->description);
          
          if($offer_object->advertiser_id && ($advertiser = $advertiser_repository->findOneByadvertiserId($offer_object->advertiser_id)))
          {
            $offer->setAdvertiser($advertiser); 
          } 
                
          foreach($offer_group_array as $offer_group_object)
          {
            if($offer_group = $offer_group_repository->findOneByOfferGroupId($offer_group_object->id))
            {
              $offer->addOfferGroup($offer_group); 
            }    
          }
          
          $offer->setOfferUrl($offer_object->offer_url);
          $offer->setPreviewUrl($offer_object->preview_url);
          $offer->setProtocol($offer_object->protocol);
          $offer->setStatus($offer_object->status);
          $offer->setExpirationDate(new \DateTime($offer_object->expiration_date));
          $offer->setPayoutType($offer_object->payout_type);
          $offer->setRevenueType($offer_object->revenue_type);
          $offer->setDefaultPayout($offer_object->default_payout);
          $offer->setMaxPayout($offer_object->max_payout);
          $offer->setPercentPayout($offer_object->percent_payout);
          $offer->setMaxPercentPayout($offer_object->max_percent_payout);
          $offer->setTieredPayout($offer_object->tiered_payout);
          $offer->setCurrency($offer_object->currency);
          $offer->setIsPrivate($offer_object->is_private);
          $offer->setRequireApproval($offer_object->require_approval);
          $offer->setRequireTermsAndConditions($offer_object->require_terms_and_conditions);
          $offer->setTermsAndConditions($offer_object->terms_and_conditions);
          $offer->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s', $offer_object->modified)));
                
          foreach($offer_category_array as $offer_category_object)
          {
            if($offer_category = $offer_category_repository->findOneByOfferCategoryId($offer_category_object->id))
            {
              $offer->addOfferCategorie($offer_category); 
            }
          }
                
          $offer_count = 0;
          if($country_array)
          {
            foreach($country_array as $country_object)
            {
              if($country = $country_repository->findOneByCode($country_object->code))
              {
                $offer->addCountrie($country);
                $offer_count++;
              } 
            }
          }
          else
          {
            foreach($countries as $country)
            {
              $offer->addCountrie($country);  
              $offer_count++;
            }
          }
          $offer->setCountryCount($offer_count);

          $manager->persist($offer); 
          $new_offers++;  
        }

        $manager->flush();
                
        $output->writeln($text);
        $output->writeln($new_offers.' new Offers added.');
    }
}
