<?php

namespace Anytv\DashboardBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Anytv\DashboardBundle\Entity\Advertiser;

class LoadAdvertiserData extends AbstractFixture implements OrderedFixtureInterface
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
	  ,'Target' => 'Advertiser'
	  ,'Method' => 'findAll'
	  ,'Service' => 'HasOffers'
	  ,'Version' => 2
	  ,'NetworkId' => 'mmotm'
	  ,'NetworkToken' => 'NETjE4MoLg7NarETCDruHecVmgLHbN'
        );
 
        $url = $base . http_build_query( $params );
 
        $result = file_get_contents( $url );
        
        $advertisers_result = (array) json_decode( $result );
        $advertisers_response = (array) $advertisers_result['response'];
        $advertisers_data = (array) $advertisers_response['data'];
        
        foreach($advertisers_data as $advertiser_data)
        {
          $advertiser_object = $advertiser_data->Advertiser;
          
          $advertiser = new Advertiser();
          $advertiser->setAdvertiserId($advertiser_object->id);
          $advertiser->setCompany($advertiser_object->company);
          $advertiser->setStatus($advertiser_object->status);
          $advertiser->setAddress1($advertiser_object->address1);
          $advertiser->setAddress2($advertiser_object->address2);
          $advertiser->setCity($advertiser_object->city);
          $advertiser->setRegion($advertiser_object->region);
          
          if($this->hasReference('country_'.$advertiser_object->country))
          {
            $advertiser->setCountry($this->getReference('country_'.$advertiser_object->country)); 
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
          
          $this->addReference('advertiser_'.$advertiser_object->id, $advertiser);
        }

        $manager->flush();
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 12; // the order in which fixtures will be loaded
    }
}
