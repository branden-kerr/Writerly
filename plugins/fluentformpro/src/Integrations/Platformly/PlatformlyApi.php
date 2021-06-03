<?php

namespace FluentFormPro\Integrations\Platformly;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class PlatformlyApi
{
    protected $apiKey = null;
    protected $projectId = null;

    private $apiUrl = "https://api.platform.ly";

    public function __construct($apiKey = null, $projectId = null)
    {
        $this->apiKey = $apiKey;
        $this->projectId = $projectId;
    }

    public function make_request($data = array(), $method = 'POST')
    {
        $data['api_key'] = $this->apiKey;

        $args =  array(
            'method'  => $method,
            'headers' => array(
                'content-type: application/x-www-form-urlencoded'
            ),
            'body'    => json_encode($data)
        );

        if($method == 'POST') {
            $response = wp_remote_post($this->apiUrl, $args);
        } else {
            $response = wp_remote_get($this->apiUrl, $args);
        }

        /* If WP_Error, die. Otherwise, return decoded JSON. */
        if (is_wp_error($response)) {
            return [
                'error'   => 'failed',
                'message' => $response->get_error_message()
            ];
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
        return $this->make_request([
            'action' => 'profile',
            'value' => new \stdClass()
        ], 'POST');
    }

    public function getLists()
    {
        $lists =  $this->make_request([
            'action' => 'list_segments',
            'value' => (object) [
                'project_id' => $this->projectId
            ],
        ], 'POST');

        if(!empty($lists['error'])) {
            return [];
        }
        return $lists;
    }

    public function getTags()
    {
        $tags =  $this->make_request([
            'action' => 'list_tags',
            'value' => (object) [
                'project_id' => $this->projectId
            ],
        ], 'POST');

        if(!empty($tags['error'])) {
            return [];
        }
        return $tags;
    }

    public function getCustomFields()
    {
        $customFields =  $this->make_request([
            'action' => 'list_custom_fields',
            'value' => (object) [
                'project_id' => $this->projectId
            ],
        ], 'POST');

        if(!empty($tags['error'])) {
            return [];
        }
        return $customFields;

    }

    public function addContact($contact)
    {
        $contact['project_id'] = $this->projectId;
        $response = $this->make_request([
            'action' => 'add_contact',
            'value' => (object) $contact
        ]);

        if(!empty($response['status']) && $response['status'] == 'success') {
            return $response;
        }

        return new \WP_Error('error', $response['message']);
    }

    public function add_note( $contact_id, $email, $note ) {
        return $this->make_request([
            'action' => 'contact_add_note',
            'value' => (object) [
                'contact_id'     => $contact_id,
                'email'          => $email,
                'note'           => $note
            ],
        ], 'POST');
    }

}