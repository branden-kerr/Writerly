<?php

namespace FluentFormPro\Integrations\Hubspot;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class API
{
    protected $apiUrl = 'https://api.hubapi.com/';

    protected $apiKey = null;


    public function __construct($apiKey = null)
    {
        $this->apiKey = $apiKey;
    }

    public function default_options()
    {
        return array(
            'hapikey' => $this->apiKey
        );
    }

    public function make_request($action, $options = array(), $method = 'GET')
    {
        /* Build request options string. */
        $request_options = $this->default_options();

        $request_options = wp_parse_args($options, $request_options);

        $options_string = http_build_query($request_options);

        /* Build request URL. */
        $request_url = $this->apiUrl . $action . '?' . $options_string;

        /* Execute request based on method. */
        switch ($method) {
            case 'POST':
                $args = array(
                    'body' => json_encode($options),
                    'headers' => [
                        'Content-Type' => 'application/json'
                    ]
                );
                $response = wp_remote_post($request_url, $args);
                break;
            case 'GET':
                $response = wp_remote_get($request_url);
                break;
        }

        /* If WP_Error, die. Otherwise, return decoded JSON. */
        if (is_wp_error($response)) {
            return new \WP_Error(400, $response->get_error_message());
        }

        return \json_decode($response['body'], true);
    }

    /**
     * Test the provided API credentials.
     *
     * @access public
     * @return bool
     */
    public function auth_test()
    {
        return $this->make_request('contacts/v1/lists', [], 'GET');
    }


    public function subscribe($listId, $values)
    {
        $values = array_filter($values);
        $properties = [];
        foreach ($values as $property => $value) {
            $properties[$property] = [
                'property' => $property,
                'value'    => $value
            ];
        }

        $properties = [
            'properties' => array_values($properties)
        ];
        $response = $this->make_request('contacts/v1/contact/', $properties, 'POST');

        if(is_wp_error($response)) {
            return $response;
        }

        if (!empty($response['error'])) {
            return new \WP_Error('api_error', $response['error']);
        }

        if(!empty($response['error']) && $response['error'] == 'CONTACT_EXISTS') {
            $contactId = $response['identityProfile']['vid'];
        } else {
            $contactId = $response['vid'];
        }

        $data = [
            'vids' => [$contactId]
        ];
        // We have the contact ID now. Let's add the list to that contact
        $updateResponse = $this->make_request('contacts/v1/lists/'.$listId.'/add', $data, 'POST');

        if(is_wp_error($updateResponse)) {
            return $updateResponse;
        }

        if (!empty($updateResponse['error'])) {
            return new \WP_Error('api_error', $updateResponse['error']);
        } else if(!$updateResponse) {
            return new \WP_Error('api_error', 'HubSpot API Request Failed');
        }

        return $contactId;
    }

    /**
     * Get all Forms in the system.
     *
     * @access public
     * @return array
     */
    public function getLists()
    {
        $response = $this->make_request('contacts/v1/lists/static', array(), 'GET');

        if(is_wp_error($response)) {
            return [];
        }

        if (!empty($response['lists'])) {
            return $response['lists'];
        }
        return [];
    }

    /**
     * Get all Tags in the system.
     *
     * @access public
     * @return array
     */
    public function getTags()
    {
        $response = $this->make_request('tags', array(), 'GET');

        if(is_wp_error($response)) {
            return false;
        }

        if (empty($response['error'])) {
            return $response['tags'];
        }
        return false;
    }

    public function getCustomFields()
    {
        $lists = $this->make_request('contacts/v1/properties', array(), 'GET');

        if(is_wp_error($lists)) {
            return [];
        }

        $customFields = array_filter($lists, function ($item) {
            return $item['hubspotDefined'] != 1;
        });

        return $customFields;
    }

}
