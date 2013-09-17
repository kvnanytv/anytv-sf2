<?php

namespace Anytv\DashboardBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Anytv\DashboardBundle\Entity\Offer;
use Anytv\DashboardBundle\Entity\OfferCategoryOffer;
use Anytv\DashboardBundle\Entity\Country;

class LoadOfferData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        //return;
        
        $base = 'https://api.hasoffers.com/Api?';
 
        $params = array(
	  'Format' => 'json'
	  ,'Target' => 'Offer'
	  ,'Method' => 'findAll'
	  ,'Service' => 'HasOffers'
	  ,'Version' => 2
	  ,'NetworkId' => 'mmotm'
	  ,'NetworkToken' => 'NETjE4MoLg7NarETCDruHecVmgLHbN'
          ,'contain'=>array('OfferCategory', 'Country')
	  ,'limit' => 500000
        );
 
        $url = $base . http_build_query( $params );
 
        $result = file_get_contents( $url );
        
        $offers_result = (array) json_decode( $result );
        $offers_response = (array) $offers_result['response'];
        $offers_data = (array) $offers_response['data'];
        $offers_data = (array) $offers_data['data'];
        
        foreach($offers_data as $offer_data)
        {
          $offer_object = $offer_data->Offer;
          $offer_category_array = $offer_data->OfferCategory;
          $country_array = $offer_data->Country;
          
          $offer = new Offer();
          $offer->setOfferId($offer_object->id);
          $offer->setName($offer_object->name);
          $offer->setDescription($offer_object->description);
          
          if($this->hasReference('advertiser_'.$offer_object->advertiser_id))
          {
            $offer->setAdvertiser($this->getReference('advertiser_'.$offer_object->advertiser_id)); 
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
          
          foreach($offer_category_array as $offer_category_object)
          {
            if($this->hasReference('offer_category_'.$offer_category_object->id))
            {
              $offer->addOfferCategorie($this->getReference('offer_category_'.$offer_category_object->id)); 
            }
          }
          
          if($country_array)
          {
            foreach($country_array as $country_object)
            {
              if($this->hasReference('country_'.$country_object->code))
              {
                $offer->addCountrie($this->getReference('country_'.$country_object->code)); 
              } 
            }
          }
          else
          {
            $country_repository = $manager->getRepository('AnytvDashboardBundle:Country');
            $countries = $country_repository->findAll();
            foreach($countries as $country)
            {
              $offer->addCountrie($country);     
            }
          }
          
          $manager->persist($offer);
          
          $this->addReference('offer_'.$offer_object->id, $offer);
        }

        $manager->flush();
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 20; // the order in which fixtures will be loaded
    }
}
