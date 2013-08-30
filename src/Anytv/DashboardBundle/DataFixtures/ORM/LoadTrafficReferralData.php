<?php

namespace Anytv\DashboardBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Anytv\DashboardBundle\Entity\TrafficReferral;

class LoadTrafficReferralData extends AbstractFixture implements OrderedFixtureInterface
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
	  ,'Target' => 'Report'
	  ,'Method' => 'getReferrals'
          ,'fields' => array('Stat.url', 'Stat.affiliate_id', 'Stat.offer_id', 'Stat.clicks', 'Stat.conversions', 'Stat.count', 'Stat.date')
          ,'groups' => array('Stat.url', 'Stat.affiliate_id', 'Stat.offer_id')
          ,'filters' => array('Stat.date' => array('conditional' => 'EQUAL_TO', 'values' => date('Y-m-d')))
          ,'sort' => array('Stat.clicks' => 'DESC')
          ,'limit' => 100000
	  ,'Service' => 'HasOffers'
	  ,'Version' => 2
	  ,'NetworkId' => 'mmotm'
	  ,'NetworkToken' => 'NETjE4MoLg7NarETCDruHecVmgLHbN'
        );
 
        $url = $base . http_build_query( $params );
 
        $result = file_get_contents( $url );
        
        $traffic_referrals_result = (array) json_decode( $result );
        $traffic_referrals_response = (array) $traffic_referrals_result['response'];
        $traffic_referrals_data = (array) $traffic_referrals_response['data'];
        $traffic_referrals_data = (array) $traffic_referrals_data['data'];
        
        foreach($traffic_referrals_data as $traffic_referral_data)
        {
          $traffic_referral_stat_object = $traffic_referral_data->Stat;
          
          $traffic_referral = new TrafficReferral();
          $traffic_referral->setAffiliateId($traffic_referral_stat_object->affiliate_id);
          $traffic_referral->setOfferId($traffic_referral_stat_object->offer_id);
          $traffic_referral->setUrl($traffic_referral_stat_object->url);
          $traffic_referral->setClicks($traffic_referral_stat_object->clicks);
          $traffic_referral->setConversions($traffic_referral_stat_object->conversions);
          $traffic_referral->setLikes(0);
          $traffic_referral->setDislikes(0);
          $traffic_referral->setCount($traffic_referral_stat_object->count);

          $manager->persist($traffic_referral);
        }

        $manager->flush();
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 13; // the order in which fixtures will be loaded
    }
}
