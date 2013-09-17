<?php

namespace Anytv\DashboardBundle\Hasoffers;

class HasoffersAPI
{
    private $api_url;
    private $api_params;

    public function __construct($api_url, $api_format, $api_service, $api_version, $api_network_id, $api_network_token)
    {
        $this->api_url = $api_url;
        
        $this->api_params = array(
	  'Format' => $api_format
	  ,'Service' => $api_service
	  ,'Version' => $api_version
	  ,'NetworkId' => $api_network_id
	  ,'NetworkToken' => $api_network_token
        );
    }

    public function getOffers()
    {
        $this->api_params['Target'] = 'Offer';
        $this->api_params['Method'] = 'findAll';
        $this->api_params['contain'] = array('OfferCategory', 'Country');
        $this->api_params['limit'] = 1000000;
        
        $url = $this->api_url . http_build_query( $this->api_params );
 
        $result = file_get_contents( $url );
        
        $result = (array) json_decode( $result );
        $response = (array) $result['response'];
        $data = (array) $response['data'];
        $data = (array) $data['data'];
        
        return $data;
    }
    
    public function getTrafficReferrals($date)
    {
        $this->api_params['Target'] = 'Report';
        $this->api_params['Method'] = 'getReferrals';
        $this->api_params['fields'] = array('Stat.url', 'Stat.affiliate_id', 'Stat.offer_id', 'Stat.clicks', 'Stat.conversions', 'Stat.count', 'Stat.date');
        $this->api_params['groups'] = array('Stat.url', 'Stat.affiliate_id', 'Stat.offer_id');
        $this->api_params['filters'] = array('Stat.date' => array('conditional' => 'EQUAL_TO', 'values' => $date));
        $this->api_params['sort'] = array('Stat.clicks' => 'DESC');
        $this->api_params['limit'] = 1000000;
        
        $url = $this->api_url . http_build_query( $this->api_params );
 
        $result = file_get_contents( $url );
        
        $result = (array) json_decode( $result );
        $response = (array) $result['response'];
        $data = (array) $response['data'];
        $data = (array) $data['data'];
        
        return $data;
        
        
    }
}