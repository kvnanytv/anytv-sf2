<?php

namespace Anytv\DashboardBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Anytv\DashboardBundle\Entity\Country;

class LoadCountryData extends AbstractFixture implements OrderedFixtureInterface
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
	  ,'Target' => 'Application'
	  ,'Method' => 'findAllCountries'
	  ,'Service' => 'HasOffers'
	  ,'Version' => 2
	  ,'NetworkId' => 'mmotm'
	  ,'NetworkToken' => 'NETjE4MoLg7NarETCDruHecVmgLHbN'
        );
 
        $url = $base . http_build_query( $params );
 
        $result = file_get_contents( $url );
        
        $countries_result = (array) json_decode( $result );
        $countries_response = (array) $countries_result['response'];
        $countries_data = (array) $countries_response['data'];
        
        foreach($countries_data as $country_data)
        {
          $country_object = $country_data->Country;
          
          $country = new Country();
          $country->setCode($country_object->code);
          $country->setName($country_object->name);

          $manager->persist($country);
          
          $this->addReference('country_'.$country_object->code, $country);
        }

        $manager->flush();
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 5; // the order in which fixtures will be loaded
    }
}
