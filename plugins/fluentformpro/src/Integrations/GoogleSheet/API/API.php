<?php

namespace FluentFormPro\Integrations\GoogleSheet\API;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class API
{
    private $clientId = '157785030834-inhccvqk9nib57i6i326q3aaecgpnctl.apps.googleusercontent.com';
    private $clientSecret = 'Rnw-FlDRRXkp0QlFSV6h1HHs';
    private $redirect = 'urn:ietf:wg:oauth:2.0:oob';

    private $optionKey = '_fluentform_google_sheet_settings';

    public function __construct()
    {
        if(defined('FF_GSHEET_CLIENT_ID')) {
            $this->clientId = FF_GSHEET_CLIENT_ID;
        }

        if(defined('FF_GSHEET_CLIENT_SECRET')) {
            $this->clientSecret = FF_GSHEET_CLIENT_SECRET;
        }

    }

    public function makeRequest($url, $bodyArgs, $type = 'GET', $headers = false)
    {
        if(!$headers) {
            $headers = array(
                'Content-Type' => 'application/http',
                'Content-Transfer-Encoding' => 'binary',
                'MIME-Version' => '1.0',
            );
        }

        $args = [
            'headers' => $headers
        ];
        if($bodyArgs) {
            $args['body'] = json_encode($bodyArgs);
        }


        $args['method'] = $type;
        $request = wp_remote_request($url, $args);

        if(is_wp_error($request)) {
            $message = $request->get_error_message();
            return new \WP_Error(423, $message);
        }

        $body = json_decode(wp_remote_retrieve_body($request), true);

        if(!empty($body['error'])) {
            $error = 'Unknown Error';
            if(isset($body['error_description'])) {
                $error = $body['error_description'];
            } else if(!empty($body['error']['message'])) {
                $error = $body['error']['message'];
            }
            return new \WP_Error(423, $error);
        }

        return $body;
    }

    public function generateAccessKey($token)
    {
        $body = [
            'code'          => $token,
            'grant_type'    => 'authorization_code',
            'redirect_uri'  => $this->redirect,
            'client_id'     => $this->clientId,
            'client_secret' => $this->clientSecret
        ];
        return $this->makeRequest('https://accounts.google.com/o/oauth2/token', $body, 'POST');
    }

    public function getAccessToken()
    {
        $tokens = get_option($this->optionKey);

        if (!$tokens) {
            return false;
        }

        if (($tokens['created_at'] + $tokens['expires_in'] - 30) < time()) {
            // It's expired so we have to re-issue again
            $refreshTokens = $this->refreshToken($tokens);

            if (!is_wp_error($refreshTokens)) {
                $tokens['access_token'] = $refreshTokens['access_token'];
                $tokens['expires_in'] = $refreshTokens['expires_in'];
                $tokens['created_at'] = time();
                update_option($this->optionKey, $tokens, 'no');
            } else {
                return false;
            }
        }

        return $tokens['access_token'];
    }

    public function getAUthUrl()
    {
        return 'https://accounts.google.com/o/oauth2/auth?access_type=offline&approval_prompt=force&client_id=' . $this->clientId . '&redirect_uri=urn%3Aietf%3Awg%3Aoauth%3A2.0%3Aoob&response_type=code&scope=https%3A%2F%2Fspreadsheets.google.com%2Ffeeds%2F';
    }

    private function refreshToken($tokens)
    {
        $args = [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'refresh_token' => $tokens['refresh_token'],
            'grant_type' => 'refresh_token'
        ];

        return $this->makeRequest('https://accounts.google.com/o/oauth2/token', $args, 'POST');
    }
}
