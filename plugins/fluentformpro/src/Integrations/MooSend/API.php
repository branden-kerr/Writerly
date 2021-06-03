<?php

namespace FluentFormPro\Integrations\MooSend;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class API
{
    protected $apiUrl = 'https://api.moosend.com/v3/';

    protected $apiKey = null;

    public function __construct($apiKey = null)
    {
        $this->apiKey = $apiKey;
    }

    public function default_options()
    {
        return array(
            'apikey' => $this->apiKey
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
                $request_url = $this->apiUrl . $action . '?apikey=' . $this->apiKey;
                $args = [];
                $args['body'] = $options;
                $args['method'] = 'POST';
                $args['headers'] = [
                    'Content-Type' => 'application/json',
                    'Accept'       => 'application/json'
                ];
                $response = wp_remote_post($request_url, $args);
                break;

            case 'GET':
                $response = wp_remote_get($request_url);
                break;
        }

        /* If WP_Error, die. Otherwise, return decoded JSON. */
        if (is_wp_error($response)) {
            return [
                'error'   => 'API_Error',
                'message' => $response->get_error_message()
            ];
        } else {
            return json_decode($response['body'], true);
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
        return $this->make_request('lists.json', [
            'WithStatistics' => false,
            'ShortBy'        => 'CreatedOn',
            'SortMethod'     => 'ASC',
            'PageSize'       => 1
        ], 'GET');
    }


    public function subscribe($formId, $data, $doubleOptIn = false)
    {
        $data['HasExternalDoubleOptIn'] = $doubleOptIn;
        $url = $this->apiUrl."subscribers/" . $formId . "/subscribe.json?apikey=" . $this->apiKey;

        if(!empty($data['CustomFields'])) {
            $customFields = $data['CustomFields'];
            $fieldPairs = [];
            foreach ($customFields as $key => $value){
                if(!$value) {
                    continue;
                }
                $fieldPairs[] = $key.'='.$value;
            }
            if($fieldPairs) {
                $data['CustomFields'] = $fieldPairs;
            }

        }

        $response = wp_remote_post($url, [
            'method' => 'POST',
            'timeout' => 45,
            'blocking' => true,
            'header' => [
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json'
            ],
            'body' => $data
        ]);


        if($response && is_wp_error($response)) {
            return new \WP_Error('request_error', $response->get_error_messages());
        }

        $responseBody = json_decode($response['body'], true);

        if(!empty($responseBody['Error'])) {
            return new \WP_Error('api_error', $response['message']);
        }

        return $responseBody['Context'];
    }

    /**
     * Get all Forms in the system.
     *
     * @access public
     * @return array
     */
    public function getLists()
    {
        $response = $this->make_request('lists.json', [
            'WithStatistics' => false,
            'ShortBy'        => 'CreatedOn',
            'SortMethod'     => 'DESC',
            'PageSize'       => 999
        ], 'GET');

        if (empty($response['Error']) && !empty($response['Context']['MailingLists'])) {
            return $response['Context']['MailingLists'];
        }
        return false;
    }

    /**
     * Get single Form in the system.
     *
     * @access public
     * @return array
     */
    public function getList($listId)
    {
        $response = $this->make_request('lists/' . $listId . '/details.json', [
            'WithStatistics' => false
        ], 'GET');

        if (empty($response['Error'])) {
            return $response['Context'];
        }
        return false;
    }

}
