<?php

namespace FluentFormPro\Integrations\MailerLite;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class API
{
    protected $apiUrl = 'https://api.mailerlite.com/api/v2/';

    protected $apiKey = null;

    protected $apiSecret = null;

    public function __construct($apiKey = null)
    {
        $this->apiKey = $apiKey;
    }

    public function default_options()
    {
        return [
            'User-Agent'          => 'MailerLite PHP SDK/2.0',
            'X-MailerLite-ApiKey' => $this->apiKey,
            'Content-Type'        => 'application/json'
        ];
    }

    public function make_request($action, $options = array(), $method = 'GET')
    {

        $headers = $this->default_options();
        $endpointUrl = $this->apiUrl . $action;
        $args = [
            'headers' => $headers
        ];

        if ($options) {
            $args['body'] = \json_encode($options);
        }

        /* Execute request based on method. */
        switch ($method) {
            case 'POST':
                $response = wp_remote_post($endpointUrl, $args);
                break;

            case 'GET':
                $response = wp_remote_get($endpointUrl, $args);
                break;
        }

        /* If WP_Error, die. Otherwise, return decoded JSON. */
        if (is_wp_error($response)) {
            return [
                'error'   => 'API_Error',
                'message' => $response->get_error_message()
            ];
        } else if ($response && $response['response']['code'] >= 300) {
            return [
                'error'   => 'API_Error',
                'message' => $response['response']['message']
            ];
        }
        return json_decode($response['body'], true);
    }

    /**
     * Test the provided API credentials.
     *
     * @access public
     * @return bool
     */
    public function auth_test()
    {
        return $this->make_request('groups', [], 'GET');
    }


    public function subscribe($formId, $data)
    {
        $response = $this->make_request('groups/' . $formId . '/subscribers', $data, 'POST');
        if (!empty($response['error'])) {
            return new \WP_Error('api_error', $response['message']);
        }
        return $response;
    }

    /**
     * Get all Forms in the system.
     *
     * @access public
     * @return array
     */
    public function getGroups()
    {
        $response = $this->make_request('groups', array(), 'GET');
        if (empty($response['error'])) {
            return $response;
        }
        return [];
    }

    public function getCustomFields()
    {
        $response = $this->make_request('fields', array(), 'GET');
        if (empty($response['error'])) {
            return $response;
        }
        return false;
    }

}
