<?php

namespace FluentFormPro\Integrations\ConstantContact;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use FluentForm\Framework\Helpers\ArrayHelper;

class API
{
    /**
     * Base Constant Contact API URL.
     *
     * @since  1.0
     * @var    string
     * @access protected
     */
    
    protected $api_url = 'https://api.constantcontact.com/v2/';
    protected $appKey = '4jzkpvcfcevnqu72kazejm66';
 
    /**
     * Constant Contact authentication data.
     *
     * @since  1.0
     * @access protected
     * @var    array $access_token Constant Contact authentication data.
     */
    protected $access_token = null;

    /**
     * Initialize Slack API library.
     *
     * @since  1.0
     *
     * @param  array $access_token Authentication token data.
     */
    public function __construct( $access_token = null ) {

        if(defined('FF_CC_APP_KEY')) {
            $this->appKey = FF_CC_APP_KEY;
        }
        $this->access_token = $access_token;

    }

    // To get the authorization url for authorization code
    public function makeAuthorizationUrl() 
    {
        return $url = 'https://api.constantcontact.com/mashery/account/'. $this->appKey ;
    }

    public function auth_test()
    {
       return $account = $this->make_request('account/info', [], 'GET');
    }


    private function getApiUrl($resource)
    {
        $parameters = [];
        if($resource =='contacts'){
            $parameters['action_by'] = 'ACTION_BY_OWNER';
        }
     
        $parameters['api_key']   = $this->appKey;
        
        $paramString = http_build_query($parameters);

        return $this->api_url . $resource . '?' . $paramString;
    }

    public function make_request($resource, $data, $method = 'GET')
    {
        $requestApi = $this->getApiUrl($resource, $data);
           
        $args =  array(
            'headers' => array(
                'Accept'        => 'application/json',
                'Content-Type'  => 'application/json',
                'Authorization' => 'Bearer'. ' ' .  $this->access_token
            ),
            'body'    => json_encode($data)
        );

       
        if ($method == 'GET') {
            $response = wp_remote_get($requestApi, $args);
        } else if ($method == 'POST') {
            $args['headers']['action_by'] = 'ACTION_BY_OWNER';
            $response = wp_remote_post($requestApi, $args);
        } else {
            return (new \WP_Error(423, 'Request method could not be found'));
        }

        /* If WP_Error, die. Otherwise, return decoded JSON. */
        if (is_wp_error($response)) {
            return (new \WP_Error(423, $response->get_error_message()));
        }

        return json_decode($response['body'], true);
    }
     
    public function get_lists(){
        return $this->make_request('lists', [], 'GET');
    }
    
    public function subscribeToList($data){
        return $this->make_request('contacts', $data, 'POST');
    }
    
    

}