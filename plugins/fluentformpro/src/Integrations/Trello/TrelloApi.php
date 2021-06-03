<?php

namespace FluentFormPro\Integrations\Trello;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class TrelloApi
{
    protected $appKey = 'f79dfb43d0becc887dc488e99bed0687';
    public $accessToken = null;
    public $apiUrl = 'https://api.trello.com/1/';

    public function __construct($accessToken = null)
    {
        if(defined('FF_TRELLO_APP_KEY')) {
            $this->appKey = FF_TRELLO_APP_KEY;
        }
        
        $this->accessToken = $accessToken;
    }

    private function getApiUrl($resource, $data = [])
    {
        $parameters = [
            'key'   => $this->appKey,
            'token' => $this->accessToken
        ];
        if ($data) {
            $parameters = wp_parse_args($parameters, $data);
        }

        $paramString = http_build_query($parameters);

        return $this->apiUrl . $resource . '?' . $paramString;
    }

    public function make_request($resource, $data, $method = 'GET')
    {
        $requestApi = $this->getApiUrl($resource, $data);

        if ($method == 'GET') {
            $response = wp_remote_get($requestApi);
        } else if ($method == 'POST') {
            $response = wp_remote_post($requestApi);
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
        return $this->make_request('members/me', [], 'GET');
    }

    public function getBoards()
    {
        return $this->make_request('members/my/boards', [], 'GET');
    }

    public function getLists($boardId)
    {
        return $this->make_request('boards/' . $boardId . '/lists', [], 'GET');
    }

    public function getLabels($boardId)
    {
        return $this->make_request('boards/' . $boardId . '/labels', [], 'GET');
    }

    public function getMembers($boardId)
    {
        return $this->make_request('boards/' . $boardId . '/members', 'GET');
    }

    public function addCard($card)
    {
        return $this->make_request('cards', $card, 'POST');
    }

}