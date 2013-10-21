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
    
    public function getAdvertisers()
    {
        $this->api_params['Target'] = 'Advertiser';
        $this->api_params['Method'] = 'findAll';
        
        $url = $this->api_url . http_build_query( $this->api_params );
 
        $result = file_get_contents( $url );
        
        $result = (array) json_decode( $result );
        $response = (array) $result['response'];
        $data = (array) $response['data'];
        
        return $data;
    }
    
    public function getOfferGroups()
    {
        $this->api_params['Target'] = 'Application';
        $this->api_params['Method'] = 'findAllOfferGroups';
        
        $url = $this->api_url . http_build_query( $this->api_params );
 
        $result = file_get_contents( $url );
        
        $result = (array) json_decode( $result );
        $response = (array) $result['response'];
        $data = (array) $response['data'];
        
        return $data;
    }

    public function getOffers($max_offer_id)
    {
        $this->api_params['Target'] = 'Offer';
        $this->api_params['Method'] = 'findAll';
        if($max_offer_id)
        {
          $this->api_params['filters'] = array('id' => array('GREATER_THAN' => $max_offer_id));
        }
        $this->api_params['contain'] = array('OfferCategory', 'Country', 'OfferGroup');
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
    
    public function getAffiliates($max_affiliate_id)
    {
        $this->api_params['Target'] = 'Affiliate';
        $this->api_params['Method'] = 'findAll';
        if($max_affiliate_id)
        {
          $this->api_params['filters'] = array('id' => array('GREATER_THAN' => $max_affiliate_id));
        }
        $this->api_params['contain'] = array('AffiliateUser');
        $this->api_params['limit'] = 1000000;
        
        $url = $this->api_url . http_build_query( $this->api_params );
 
        $result = file_get_contents( $url );
        
        $result = (array) json_decode( $result );
        $response = (array) $result['response'];
        $data = (array) $response['data'];
        $data = (array) $data['data'];
        
        return $data;
    }
    
    public function getPlayNowLink($offer_id, $affiliate_id)
    {
        $this->api_params['Target'] = 'Offer';
        $this->api_params['Method'] = 'generateTrackingLink';
        $this->api_params['offer_id'] = $offer_id;
        $this->api_params['affiliate_id'] = $affiliate_id;
        
        $url = $this->api_url . http_build_query( $this->api_params );
 
        $result = file_get_contents( $url );
        
        $result = (array) json_decode( $result );
        $response = (array) $result['response'];
        $data = $response['data'];
        
        return $data;
    }
    
    public function authenticateUser($email, $password, $type)
    {
        $this->api_params['Target'] = 'Authentication';
        $this->api_params['Method'] = 'findUserByCredentials';
        $this->api_params['email'] = $email;
        $this->api_params['password'] = $password;
        $this->api_params['type'] = $type;
        
        $url = $this->api_url . http_build_query( $this->api_params );
 
        $result = file_get_contents( $url );
        
        $result = (array) json_decode( $result );
        $response = (array) $result['response'];
        
        return $response;
    }
    
    public function getPaypalEmail($affiliate_id)
    {
        $this->api_params['Target'] = 'Affiliate';
        $this->api_params['Method'] = 'getPaymentMethods';
        $this->api_params['id'] = $affiliate_id;
        
        $url = $this->api_url . http_build_query( $this->api_params );
 
        $result = file_get_contents( $url );
        
        $result = (array) json_decode( $result );
        $response = (array) $result['response'];
        $data = (array) $response['data'];
        $paypal = (array) $data['Paypal'];
        return isset($paypal['email']) ? $paypal['email'] : null;
    }
    
    public function signup($affiliate_data, $affiliate_user_data)
    {
        $this->api_params['Target'] = 'Affiliate';
        $this->api_params['Method'] = 'signup';
        $this->api_params['account'] = $affiliate_data;
        $this->api_params['user'] = $affiliate_user_data;
        
        $url = $this->api_url . http_build_query( $this->api_params );
 
        $result = file_get_contents( $url );
        
        $result = (array) json_decode( $result );
        $response = (array) $result['response'];
        
        return $response;
    }
    
    public function resetPassword($affiliate_user_id)
    {
        $this->api_params['Target'] = 'AffiliateUser';
        $this->api_params['Method'] = 'resetPassword';
        $this->api_params['id'] = $affiliate_user_id;
        $this->api_params['length'] = 12;
        
        $url = $this->api_url . http_build_query( $this->api_params );
 
        $result = file_get_contents( $url );
        
        $result = (array) json_decode( $result );
        
        return $result['response'];
    }
    
    public function updateAffiliateUserField($affiliate_user_id, $field_name, $field_value, $return_object = true)
    {
        $this->api_params['Target'] = 'AffiliateUser';
        $this->api_params['Method'] = 'updateField';
        $this->api_params['id'] = $affiliate_user_id;
        $this->api_params['field'] = $field_name;
        $this->api_params['value'] = $field_value;
        $this->api_params['return_object'] = $return_object;
        
        $url = $this->api_url . http_build_query( $this->api_params );
 
        $result = file_get_contents( $url );
        
        $result = (array) json_decode( $result );
        
        return $result['response'];
    }
}