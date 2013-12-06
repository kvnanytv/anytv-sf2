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
    
    public function getCountries()
    {
        $this->api_params['Target'] = 'Application';
        $this->api_params['Method'] = 'findAllCountries';
        
        $url = $this->api_url . http_build_query( $this->api_params );
 
        $result = file_get_contents( $url );
        
        $result = (array) json_decode( $result );
        $response = (array) $result['response'];
        $data = (array) $response['data'];
        
        return $data;
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
    
    public function getOfferCategories()
    {
        $this->api_params['Target'] = 'Application';
        $this->api_params['Method'] = 'findAllOfferCategories';
        $this->api_params['filters'] = array('status'=>'active');
        
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
    
    public function getUpdatedOffers($max_updated_at)
    {
        $this->api_params['Target'] = 'Offer';
        $this->api_params['Method'] = 'findAll';
        if($max_updated_at)
        {
          //$this->api_params['filters'] = array('modified' => array('conditional' => 'GREATER_THAN_OR_EQUAL_TO', 'values' => $max_updated_at));    
          $this->api_params['filters'] = array('modified' => array('GREATER_THAN' => $max_updated_at));
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
    
    public function getOffer($offer_id)
    {
        $this->api_params['Target'] = 'Offer';
        $this->api_params['Method'] = 'findById';
        $this->api_params['id'] = $offer_id;
        $this->api_params['contain'] = array('OfferCategory', 'Country', 'OfferGroup');
        
        $url = $this->api_url . http_build_query( $this->api_params );
 
        $result = file_get_contents( $url );
        
        $result = (array) json_decode( $result );
        
        return $result['response'];
    }
    
    public function getTrafficReferrals($max_traffic_referral_date)
    {
        $this->api_params['Target'] = 'Report';
        $this->api_params['Method'] = 'getReferrals';
        
        if($max_traffic_referral_date)
        {
          $this->api_params['filters'] = array('Stat.date' => array('conditional' => 'GREATER_THAN_OR_EQUAL_TO', 'values' => $max_traffic_referral_date));    
        }
        
        $this->api_params['fields'] = array('Stat.url', 'Stat.affiliate_id', 'Stat.offer_id', 'Stat.clicks', 'Stat.conversions', 'Stat.count', 'Stat.date');
        $this->api_params['groups'] = array('Stat.url', 'Stat.affiliate_id', 'Stat.offer_id');
        $this->api_params['sort'] = array('Stat.date' => 'ASC');
        $this->api_params['limit'] = 2000;
        
        $url = $this->api_url . http_build_query( $this->api_params );
 
        $result = file_get_contents( $url );
        
        $result = (array) json_decode( $result );
        $response = (array) $result['response'];
        $data = (array) $response['data'];
        $data = (array) $data['data'];
        
        return $data;
    }
    
    public function getTrafficReferralsByDate($traffic_referral_date)
    {
        $this->api_params['Target'] = 'Report';
        $this->api_params['Method'] = 'getReferrals';
        $this->api_params['filters'] = array('Stat.date' => array('conditional' => 'EQUAL_TO', 'values' => $traffic_referral_date));    
        $this->api_params['fields'] = array('Stat.url', 'Stat.affiliate_id', 'Stat.offer_id', 'Stat.clicks', 'Stat.conversions', 'Stat.count', 'Stat.date');
        $this->api_params['groups'] = array('Stat.url', 'Stat.affiliate_id', 'Stat.offer_id');
        $this->api_params['sort'] = array('Stat.date' => 'ASC');
        $this->api_params['limit'] = 100000;
        
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
    
    public function updatePaypalEmail($affiliate_id, $data)
    {
        $this->api_params['Target'] = 'Affiliate';
        $this->api_params['Method'] = 'updatePaymentMethodPaypal';
        $this->api_params['affiliate_id'] = $affiliate_id;
        $this->api_params['data'] = $data;
        
        $url = $this->api_url . http_build_query( $this->api_params );
 
        $result = file_get_contents( $url );
        
        $result = (array) json_decode( $result );
        
        return $result['response'];
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
    
    public function updateAffiliate($affiliate_id, $data, $return_object = true)
    {
        $this->api_params['Target'] = 'Affiliate';
        $this->api_params['Method'] = 'update';
        $this->api_params['id'] = $affiliate_id;
        $this->api_params['data'] = $data;
        $this->api_params['return_object'] = $return_object;
        
        $url = $this->api_url . http_build_query( $this->api_params );
 
        $result = file_get_contents( $url );
        
        $result = (array) json_decode( $result );
        
        return $result['response'];
    }
    
    public function updateAffiliateUser($affiliate_user_id, $data, $return_object = true)
    {
        $this->api_params['Target'] = 'AffiliateUser';
        $this->api_params['Method'] = 'update';
        $this->api_params['id'] = $affiliate_user_id;
        $this->api_params['data'] = $data;
        $this->api_params['return_object'] = $return_object;
        
        $url = $this->api_url . http_build_query( $this->api_params );
 
        $result = file_get_contents( $url );
        
        $result = (array) json_decode( $result );
        
        return $result['response'];
    }
    
    public function getConversions($max_conversion_id)
    {
        $this->api_params['Target'] = 'Report';
        $this->api_params['Method'] = 'getConversions';
        if($max_conversion_id)
        {
          $this->api_params['filters'] = array('Stat.id' => array('conditional' => 'GREATER_THAN', 'values' => $max_conversion_id));
        }
        $this->api_params['fields'] = array('Stat.id', 'Stat.ip', 'Stat.ad_id', 'Stat.status', 'Stat.payout', 'Stat.revenue', 'Stat.sale_amount', 'Stat.is_adjustment', 'Stat.datetime', 'Stat.affiliate_id', 'Stat.offer_id', 'Stat.source', 'Stat.refer', 'Stat.pixel_refer');
        $this->api_params['limit'] = 2500;
        
        $url = $this->api_url . http_build_query( $this->api_params );
 
        $result = file_get_contents( $url );
        
        $result = (array) json_decode( $result );
        $response = (array) $result['response'];
        $data = (array) $response['data'];
        $data = isset($data['data']) ? (array) $data['data'] : $data;
        
        return $data;
    }
    
    public function updateConversionField($conversion_id, $field_name, $field_value, $return_object = true)
    {
        $this->api_params['Target'] = 'Conversion';
        $this->api_params['Method'] = 'updateField';
        $this->api_params['id'] = $conversion_id;
        $this->api_params['field'] = $field_name;
        $this->api_params['value'] = $field_value;
        $this->api_params['return_object'] = $return_object;
        
        $url = $this->api_url . http_build_query( $this->api_params );
 
        $result = file_get_contents( $url );
        
        $result = (array) json_decode( $result );
        
        return $result['response'];
    }
    
    public function getAffiliateConversions($affiliate_id, $page)
    {
        $this->api_params['Target'] = 'Report';
        $this->api_params['Method'] = 'getConversions';
        $this->api_params['filters'] = array('Stat.affiliate_id' => array('conditional' => 'EQUAL_TO', 'values' => $affiliate_id), 'Stat.status' => array('conditional' => 'EQUAL_TO', 'values' => 'approved'));
        $this->api_params['fields'] = array('Stat.id', 'Stat.ip', 'Stat.ad_id', 'Stat.status', 'Stat.payout', 'Stat.datetime', 'Stat.affiliate_id', 'Stat.offer_id');
        $this->api_params['sort'] = array('Stat.id' => 'DESC');
        $this->api_params['limit'] = 10;
        $this->api_params['page'] = $page;
        
        $url = $this->api_url . http_build_query( $this->api_params );
 
        $result = file_get_contents( $url );
        
        $result = (array) json_decode( $result );
        $response = (array) $result['response'];
        $data = $response['data'];
        
        return $data;  
    }
    
    public function getReferrals($max_referral_date)
    {
        $this->api_params['Target'] = 'Report';
        $this->api_params['Method'] = 'getAffiliateCommissions';
        if($max_referral_date)
        {
          $this->api_params['filters'] = array('Stat.date' => array('conditional' => 'GREATER_THAN_OR_EQUAL_TO', 'values' => $max_referral_date));
        }
        $this->api_params['fields'] = array('Stat.amount', 'Stat.referral_id', 'Stat.affiliate_id', 'Stat.date');
        $this->api_params['groups'] = array('Stat.date', 'Stat.referral_id', 'Stat.affiliate_id');
        $this->api_params['sort'] = array('Stat.date' => 'ASC');
        $this->api_params['limit'] = 1000;
        
        $url = $this->api_url . http_build_query( $this->api_params );
 
        $result = file_get_contents( $url );
        
        $result = (array) json_decode( $result );
        $response = (array) $result['response'];
        $data = (array) $response['data'];
        $data = (array) $data['data'];
        
        return $data;
    }
    
    public function getReferralsByDate($referral_date)
    {
        $this->api_params['Target'] = 'Report';
        $this->api_params['Method'] = 'getAffiliateCommissions';
        $this->api_params['filters'] = array('Stat.date' => array('conditional' => 'EQUAL_TO', 'values' => $referral_date));
        $this->api_params['fields'] = array('Stat.amount', 'Stat.referral_id', 'Stat.affiliate_id', 'Stat.date', 'Stat.var_total');
        $this->api_params['groups'] = array('Stat.date', 'Stat.referral_id', 'Stat.affiliate_id');
        $this->api_params['sort'] = array('Stat.affiliate_id' => 'DESC');
        $this->api_params['limit'] = 10000;
        
        $url = $this->api_url . http_build_query( $this->api_params );
 
        $result = file_get_contents( $url );
        
        $result = (array) json_decode( $result );
        $response = (array) $result['response'];
        $data = (array) $response['data'];
        $data = (array) $data['data'];
        
        return $data;
    }
    
    public function getAffiliateCommissions($affiliate_id, $page)
    {
        $this->api_params['Target'] = 'Report';
        $this->api_params['Method'] = 'getAffiliateCommissions';
        $this->api_params['filters'] = array('Stat.referral_id' => array('conditional' => 'EQUAL_TO', 'values' => $affiliate_id));
        $this->api_params['fields'] = array('Stat.amount', 'Stat.referral_id', 'Stat.affiliate_id', 'Stat.date', 'ReferredAffiliate.company');
        $this->api_params['groups'] = array('Stat.affiliate_id');
        $this->api_params['sort'] = array('ReferredAffiliate.company' => 'ASC');
        $this->api_params['limit'] = 10;
        $this->api_params['page'] = $page;
        
        $url = $this->api_url . http_build_query( $this->api_params );
 
        $result = file_get_contents( $url );
        
        $result = (array) json_decode( $result );
        $response = (array) $result['response'];
        $data = $response['data'];
        
        return $data;  
    }
    
    public function getSignupQuestions()
    {
        $this->api_params['Target'] = 'Affiliate';
        $this->api_params['Method'] = 'getSignupQuestions';
        
        $url = $this->api_url . http_build_query( $this->api_params );
 
        $result = file_get_contents( $url );
        
        $result = (array) json_decode( $result );
        $response = (array) $result['response'];
        $data = (array) $response['data'];
        
        return $data;
    }
    
    public function createSignupQuestionAnswer($affiliate_id, $signup_question_id, $answer)
    {
        $this->api_params['Target'] = 'Affiliate';
        $this->api_params['Method'] = 'createSignupQuestionAnswer';
        $this->api_params['id'] = $affiliate_id;
        $this->api_params['data'] = array('question_id'=>$signup_question_id, 'answer'=>$answer);
        
        $url = $this->api_url . http_build_query( $this->api_params );
 
        $result = file_get_contents( $url );
        
        $result = (array) json_decode( $result );
        $response = (array) $result['response'];
        
        return $response;
    }
    
    public function updateSignupQuestionAnswer($answer_id, $answer)
    {
        $this->api_params['Target'] = 'Affiliate';
        $this->api_params['Method'] = 'updateSignupQuestionAnswer';
        $this->api_params['answer_id'] = $answer_id;
        $this->api_params['data'] = array('answer'=>$answer);
        
        $url = $this->api_url . http_build_query( $this->api_params );
 
        $result = file_get_contents( $url );
        
        $result = (array) json_decode( $result );
        $response = (array) $result['response'];
        
        return $response;
    }
    
    public function getSignupAnswers($affiliate_id)
    {
        $this->api_params['Target'] = 'Affiliate';
        $this->api_params['Method'] = 'getSignupAnswers';
        $this->api_params['id'] = $affiliate_id;
        
        $url = $this->api_url . http_build_query( $this->api_params );
 
        $result = file_get_contents( $url );
        
        $result = (array) json_decode( $result );
        $response = $result['response'];
        
        return $response;
    }
    
    public function getReferralCommission($affiliate_id)
    {
        $this->api_params['Target'] = 'Affiliate';
        $this->api_params['Method'] = 'getReferralCommission';
        $this->api_params['id'] = $affiliate_id;
        
        $url = $this->api_url . http_build_query( $this->api_params );
 
        $result = file_get_contents( $url );
        
        $result = json_decode($result);
        
        return $result->response;
    }
}