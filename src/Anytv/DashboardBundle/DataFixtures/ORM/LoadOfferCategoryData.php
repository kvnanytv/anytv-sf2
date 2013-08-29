<?php

namespace Anytv\DashboardBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Anytv\DashboardBundle\Entity\OfferCategory;

class LoadOfferCategoryData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $base = 'https://api.hasoffers.com/Api?';
 
        $params = array(
	  'Format' => 'json'
	  ,'Target' => 'Application'
	  ,'Method' => 'findAllOfferCategories'
	  ,'Service' => 'HasOffers'
	  ,'Version' => 2
	  ,'NetworkId' => 'mmotm'
	  ,'NetworkToken' => 'NETjE4MoLg7NarETCDruHecVmgLHbN'
          ,'filters'=>array('status'=>'active')
	  ,'limit' => 500000
        );
 
        $url = $base . http_build_query( $params );
 
        $result = file_get_contents( $url );
        
        $offer_categories_result = (array) json_decode( $result );
        $offer_categories_response = (array) $offer_categories_result['response'];
        $offer_categories_data = (array) $offer_categories_response['data'];
        
        foreach($offer_categories_data as $offer_category_data)
        {
          $offer_category_object = $offer_category_data->OfferCategory;
          
          $offer_category = new OfferCategory();
          $offer_category->setOfferCategoryId($offer_category_object->id);
          $offer_category->setName($offer_category_object->name);
          $offer_category->setStatus($offer_category_object->status);
          $offer_category->setOfferCount($offer_category_object->offer_count);

          $manager->persist($offer_category);
          
          $this->addReference('offer_category_'.$offer_category_object->id, $offer_category);
        }

        $manager->flush();
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 11; // the order in which fixtures will be loaded
    }
}
