<?php

namespace FluentFormPro\Integrations\Sendinblue;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class SendinblueApi
{
    protected $apiKey = null;

    private $apiUrl = "https://api.sendinblue.com/v3/";

    public function __construct($apiKey = null)
    {
        $this->apiKey = $apiKey;
    }

    public function make_request($path, $data = array(), $method = 'POST')
    {
       
      
        $args =  array(
            'method'  => $method,
            'headers' => array(
                'accept'=> 'application/json',
                'content-type' => 'application/json',
                'api-key'=> $this->apiKey
            )
        );

        if(!empty($data)){
            $data["updateEnabled"] = false;
            $args['body'] = json_encode($data);
        }
  
        $apiUrl = $this->apiUrl . $path;
  
        if($method == 'POST') {
            $response = wp_remote_post($apiUrl, $args);
        } else if($method == 'GET') {
            $response = wp_remote_get($apiUrl, $args);
        } else if($method == 'PUT') {
            $response = wp_remote_request($apiUrl, $args);
        } else {
            return (new \WP_Error(423, 'Request method could not be found'));
        }

       /* If WP_Error, die. Otherwise, return decoded JSON. */
       if (is_wp_error($response)) {
        return (new \WP_Error(423, $response->get_error_message()));
       }
        return json_decode($response['body'], true);
    }

    /**
     * Test the provided API credentials.
     *
     * @access public
     * @return Array
     */
    public function auth_test()
    {
       return $auth =  $this->make_request('account/', [], 'GET');
    }

    public function getLists()
    {
        $lists =  $this->make_request('contacts/lists?limit=50&offset=0&sort=desc', [], 'GET');

        if(is_wp_error($lists) || empty($lists['lists'])) {
            return [];
        }

        return $lists;
    }
    public function attributes()
    {
        $attributes =  $this->make_request('contacts/attributes', [], 'GET');

        if(!empty($lists['error'])) {
            return [];
        }
        return $attributes;  
    }

	public function addContact($data)
    {  
        $response = $this->make_request('contacts/', $data, 'POST');
        if(!empty($response['id'])) {
            return $response;
        } else {
            // TODO: Check if error is "contact already exists"

            // Add contact to the lists
            //return $this->addContactToList($data);
			return $this->updateContact($data);
        }

        return new \WP_Error('error', $response['message']);
    }

    public function addContactToList($data)
    {  
        // Create new data object
		$add_contact_to_list = [];
		$add_contact_to_list['emails'] = [$data['email']];
		
		$response = $this->make_request('contacts/lists/' . $data['listIds'][0] . '/contacts/add', $add_contact_to_list, 'POST');
        if (!empty($response['contacts']['success'])) {
            $response_success = [];
            $response_success['id'] = 1;
            return $response_success;
        }

        return new \WP_Error('error', $response['message']);
    }
	
	public function updateContact($data)
    {  
        $response = $this->make_request('contacts/' . urlencode($data['email']), $data, 'PUT');
        if (empty($response)) {
			$response_success = [];
			$response_success['id'] = 1;
			return $response_success;
        }
		
		return new \WP_Error('error', $response['message']);
    }

}