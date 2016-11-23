<?php

namespace JL\GlovoApi\HTTP;

use GuzzleHttp\Client as HttpClient;

use JL\GlovoApi\Config;

class HttpRequester
{

    private $baseUrl;

    public function __construct($baseUrl = Config::STAGE_URL, $client = null)
    {
        $this->baseUrl = $baseUrl;
        $this->client = $client;
        if(is_null($this->client))
        {
            $this->client = new HttpClient(
                 ['base_uri' => $this->baseUrl]
            );
        }
    }

    public function postJson($url, $parameters)
    {
        $response = $this->client->request('POST', $url,
            ['headers' => ['Content-Type' => 'application/json', 'Accept' => 'application/json'],
             'body' => json_encode($parameters)
            ]
        );
        return new HttpResponse($response->getStatusCode(), $response->getReasonPhrase(), json_decode($response->getBody(), true));
    }

    public function deleteAuthorization($url, $token)
    {
        $response = $this->client->request('DELETE', $url,
            ['headers' =>
                [
                    'Accept' => 'application/json',
                    'Authorization' => $token
                ]
            ]
        );
        return new HttpResponse($response->getStatusCode(), $response->getReasonPhrase(), json_decode($response->getBody(), true));
    }
}
