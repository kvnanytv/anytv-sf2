<?php

namespace Anytv\DashboardBundle\Hasoffers;

class HasoffersAPI
{
    private $api_url;
    private $api_format;
    private $api_service;
    private $api_version;
    private $api_network_id;
    private $api_network_token;

    public function __construct($api_url, $api_format, $api_service, $api_version, $api_network_id, $api_network_token)
    {
        $this->api_url = $api_url;
        $this->api_format = $api_format;
        $this->api_service = $api_service;
        $this->api_version = $api_version;
        $this->api_network_id = $api_network_id;
        $this->api_network_token = $api_network_token;
    }

    public function getOffers()
    {
        $params = array(
	  'Format' => $this->api_format
	  ,'Target' => 'Offer'
	  ,'Method' => 'findAll'
	  ,'Service' => $this->api_service
	  ,'Version' => $this->api_version
	  ,'NetworkId' => $this->api_network_id
	  ,'NetworkToken' => $this->api_network_token
          ,'contain'=>array('OfferCategory', 'Country')
	  ,'limit' => 50000
        );
        
        $url = $this->api_url . http_build_query( $params );
 
        $result = file_get_contents( $url );
        
        $offers_result = (array) json_decode( $result );
        $offers_response = (array) $offers_result['response'];
        $offers_data = (array) $offers_response['data'];
        $offers_data = (array) $offers_data['data'];
        
        return $offers_data;
    }
    
    public function getTrafficReferrals($date)
    {
        $params = array(
	  'Format' => $this->api_format
	  ,'Target' => 'Offer'
	  ,'Method' => 'findAll'
	  ,'Service' => $this->api_service
	  ,'Version' => $this->api_version
	  ,'NetworkId' => $this->api_network_id
	  ,'NetworkToken' => $this->api_network_token
          ,'contain'=>array('OfferCategory', 'Country')
	  ,'limit' => 50000
        );
    }
}