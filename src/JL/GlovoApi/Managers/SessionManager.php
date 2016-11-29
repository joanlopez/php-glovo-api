<?php

namespace JL\GlovoApi\Managers;

use JL\GlovoApi\HTTP\HttpRequester;

class SessionManager
{
    const LOGIN_URL = 'v1/oauth/token';
    const LOGOUT_URL = 'v1/oauth/token';

    private $httpRequester;

    public function __construct($httpRequester = null)
    {
        $this->httpRequester = (is_null($httpRequester)) ? new HttpRequester() : $httpRequester;
    }

    public function login($clientId, $clientSecret)
    {
        $response = $this->httpRequester->postJson(self::LOGIN_URL, array('clientId' => $clientId, 'clientSecret' => $clientSecret));
        $token = ($response->wasSuccessful()) ? $response->parameter('token') : null;
        return $token;
    }

    public function logout($token)
    {
        $response = $this->httpRequester->deleteAuthorization(self::LOGOUT_URL, $token);
        return $response->wasSuccessful();
    }
}
