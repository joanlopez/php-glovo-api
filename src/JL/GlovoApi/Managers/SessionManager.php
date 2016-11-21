<?php

namespace JL\GlovoApi\Managers;

use JL\GlovoApi\HTTP\HttpRequester;

class SessionManager
{
    const LOGIN_URL = 'oauth/token';
    const LOGOUT_URL = 'oauth/token';

    private $httpRequester;

    public function __construct($httpRequester = null)
    {
        $this->httpRequester = (is_null($httpRequester)) ? new HttpRequester() : $httpRequester;
    }

    public function login($clientId, $clientSecret)
    {
        $response = $this->httpRequester->postJson(self::LOGIN_URL, array('clientId' => $clientId, 'clientSecret' => $clientSecret));
        $token = ($response->wasSuccessful()) ? $response->parameters('token') : null;
        return $token;
    } 
}
