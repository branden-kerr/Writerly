<?php

namespace FluentFormPro\Integrations\SMSNotification;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class TwillioApi
{
	protected $apiUrl = 'https://api.twilio.com/2010-04-01/';
	
	protected $authToken = null;

	protected $accountSID = null;

	public function __construct( $authToken = null, $accountSID = null )
	{	
		$this->authToken = $authToken;
		$this->accountSID = $accountSID;
	}

	public function default_options()
	{
		return array(
			'api_key'    => $this->apiKey
		);
	}

	public function make_request( $action, $options = array(), $method = 'GET' )
	{
        $args = array(
            'headers' => array(
                'Authorization' => 'Basic ' . base64_encode( $this->accountSID . ':' . $this->authToken ),
                'Content-Type' => 'application/json',
            )
        );

		/* Build request URL. */
		$request_url = $this->apiUrl  . $action;

		/* Execute request based on method. */
		switch ( $method ) {
			case 'POST':
			    $args['headers']['Content-Type'] = 'application/x-www-form-urlencoded';
                //$request_url .= '?'.http_build_query($options);
                $args['body'] = $options;
				$response = wp_remote_post( $request_url, $args );
				break;
				
			case 'GET':
				$response = wp_remote_get( $request_url, $args );
				break;
		}

		/* If WP_Error, die. Otherwise, return decoded JSON. */
		if ( is_wp_error( $response ) ) {
			return [
			    'error' => 'API_Error',
                'message' => $response->get_error_message(),
                'response' => $response
            ];
		} else if($response['response']['code'] >= 300) {
            return [
                'error'    => 'API_Error',
                'message'  => $response['response']['message'],
                'response' => $response
            ];
        } else {
            return json_decode( $response['body'], true );
        }
	}
	
	/**
	 * Test the provided API credentials.
	 * 
	 * @access public
	 * @return bool
	 */
	public function auth_test()
	{
	    return $this->make_request('Accounts.json', [], 'GET');
	}


	public function sendSMS($accountId, $data)
    {
        $response = $this->make_request('Accounts/'.\rawurlencode($accountId).'/Messages.json', $data, 'POST');

        if(!empty($response['error'])) {
            return new \WP_Error('api_error', $response['message']);
        }
        
        return $response;
    }

}
