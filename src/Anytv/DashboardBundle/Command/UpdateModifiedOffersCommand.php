<?php

namespace Anytv\DashboardBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Anytv\DashboardBundle\Entity\Offer;

class UpdateModifiedOffersCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('anytv:update_modified_offers')
            ->setDescription('Updating Modified Offers from Hasoffers to database.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //date_default_timezone_set('America/Los_Angeles');
        
        $script_tz = date_default_timezone_get();

        if (strcmp($script_tz, ini_get('date.timezone'))){
          echo 'Script timezone differs from ini-set timezone.';
        } else {
          echo 'Script timezone and ini-set timezone match.';
        }
        echo $script_tz;

        $text = 'Updating Modified Offers from Hasoffers to database.';
        $container = $this->getContainer();
        $doctrine = $container->get('doctrine');
        $repository = $doctrine->getRepository('AnytvDashboardBundle:Offer');
        $advertiser_repository = $doctrine->getRepository('AnytvDashboardBundle:Advertiser');
        $offer_category_repository = $doctrine->getRepository('AnytvDashboardBundle:OfferCategory');
        $offer_group_repository = $doctrine->getRepository('AnytvDashboardBundle:OfferGroup');
        $country_repository = $doctrine->getRepository('AnytvDashboardBundle:Country');
        $countries = $country_repository->findAll();
        $manager = $doctrine->getManager();
        $hasoffers = $container->get('hasoffers');
        
        $max_updated_at = $repository->getMaxUpdatedAt();
        $updated_offers = $hasoffers->getUpdatedOffers($max_updated_at);
          
        $updated_offers_count = 0;
        $updated_offers_names = array();
        foreach($updated_offers as $offer_data)
        {
          $offer_object = $offer_data->Offer;
          $offer_category_array = $offer_data->OfferCategory;
          $country_array = $offer_data->Country;
          $offer_group_array = $offer_data->OfferGroup;
          
          $offer = $repository->findOneByOfferId($offer_object->id);
          
          if($offer)
          {
            $offer->setName($offer_object->name);
            $offer->setDescription($offer_object->description);
          
            if($offer_object->advertiser_id && ($advertiser = $advertiser_repository->findOneByadvertiserId($offer_object->advertiser_id)))
            {
              $offer->setAdvertiser($advertiser); 
            } 
                
            $offer->getOfferGroups()->clear();
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
                
            $offer->getOfferCategories()->clear();
            foreach($offer_category_array as $offer_category_object)
            {
              if($offer_category = $offer_category_repository->findOneByOfferCategoryId($offer_category_object->id))
              {
                $offer->addOfferCategorie($offer_category); 
              }
            }
                
            $offer->getCountries()->clear();
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
            
            $updated_offers_count++;
            $updated_offers_names[] = $offer.':'.$offer_object->id.' - '.date('Y-m-d H:i:s', $offer_object->modified).' - '.$offer_object->modified;
          }
        }

        $manager->flush();
                
        $output->writeln($text);
        $output->writeln($updated_offers_count.' Offers updated. - '.implode(", ", $updated_offers_names));
    }
}
