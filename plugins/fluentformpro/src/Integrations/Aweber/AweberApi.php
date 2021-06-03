<?php

namespace FluentFormPro\Integrations\Aweber;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

 class AweberApi
{
    protected $authorizeCode = null;
    protected $accessToken = null;
    protected $refreshToken = null;
    private $clientId = "NXk0nC3K4XJ38OnX3kzaEmKXXqjXgBaj";
    private $clientSecret = "RWpqGw24OrcXIDp7v6Bg70QdOxdUybmW";
    private $redirectUri = "urn:ietf:wg:oauth:2.0:oob";
    


    private $apiUrl = 'https://auth.aweber.com/oauth2/';

    public function __construct($settings = [])
    {
        extract($settings);
        $this->authorizeCode = $authorizeCode;  
        if($access_token && $refresh_token){
            $this->accessToken = $access_token;
            $this->refreshToken = $refresh_token;
        }
    }

    // To get the authorization url for authorization code
    public function makeAuthorizationUrl() 
    {
        $attr = [
            'response_type'=>'code',
            'client_id' =>  $this->clientId,
            'redirect_uri' => $this->$redirectUri,
            'scope' => ['account.read', 'list.read', 'subscriber.read','subscriber.write', 'email.read','email.write','subscriber.read-extended'],
            'state' =>  $this->clientSecret,
            // 'code_challenge'=> 'challenge',
            // 'code_challenge_method'=> 'S256'
        ];
        $paramString = http_build_query($attr);
        return $url = $this->apiUrl . 'authorize' . '?' . $paramString;
    }

    // All request will go through this function
    public function getAccessToken($resource, $data = array(), $method = 'POST')
    {
        $requestApi = $this->apiUrl . $resource;
        $args =  array(
            'headers' => array(
                'Accept'    => 'application/json',
            ),
            'body'    => $data
        );
        $response = wp_remote_post($requestApi, $args);
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
     * Test the provided access token, refress token  info.
     *
     * @access public
     * @return Array
     */
    public function auth_test()
    {
        $resource = 'token';
        $data = array(
            'grant_type'    => 'authorization_code',
            'code'          => $this->authorizeCode,
            "client_id"     => $this->clientId,
            "client_secret" => $this->clientSecret
        );
        return $this->getAccessToken($resource, $data, 'POST');
    }


    public function make_request($path, $data=[], $method='GET' )
    {   
        $url = 'https://api.aweber.com/1.0/' . $path;

        $args =  array(
            'headers' => array(
                'Accept'    => 'application/json',
                'Authorization' => 'Bearer nBR12pahFmg80vKnaPs20D9fMjLyCurO'
            ),
            'body'    => $data
        );
    
        if($method == 'GET') {
            // $url = add_query_arg($data, $url);
            $response = wp_remote_get($url,$args);
        } else if($method == 'POST') {
            $response = wp_remote_post($url, [
                'body' => $data
            ]);
        }
        return $response;
    }


    // public function makeAuthString()
    // {       
    //     $userCredentials =  $this->clientId . ':' . $this->clientSecret;
    //     return $authstring = 'Basic ' . base64_encode($userCredentials);    
    // }


    // private function getApiUrl($resource, $data = [])
    // {   
    //     if ($data) {
    //          $paramString = http_build_query($data);
    //     }
       
    //     return $this->apiUrl . $resource['path'] . '?' . $paramString;
    // }



    public function getLists()
    {
        $lists =  $this->make_request([
            
        ], 'POST');

        if(!empty($lists['error'])) {
            return [];
        }
        return $lists;
    }

    public function getTags()
    {
        $tags =  $this->make_request([
            
        ], 'POST');

        if(!empty($tags['error'])) {
            return [];
        }
        return $tags;
    }

    public function getCustomFields()
    {
        $customFields =  $this->make_request([
           
        ], 'POST');

        if(!empty($tags['error'])) {
            return [];
        }
        return $customFields;

    }

    public function addContact($contact)
    {
        $response = $this->make_request('accounts', [], $method='GET');
        dd($response);
        return new \WP_Error('error', $response['message']);
    }

}