<?php

namespace JL\GlovoApi\HTTP;

class HttpResponse
{

    private $statusCode;
    private $statusPhrase;
    private $wasSuccessful;
    private $parameters;

    public function __construct($statusCode, $statusPhrase, $parameters)
    {
        $this->statusCode = $statusCode;
        $this->statusPhrase = $statusPhrase;
        $this->parameters = $parameters;
        $this->wasSuccessful = (($statusCode / 100) == 2) ? true : false;
    }

    public function statusCode()
    {
        return $this->statusCode;
    }

    public function statusPhrase()
    {
        return $this->statusPhrase;
    }

    public function wasSuccessful()
    {
        return $this->wasSuccessful;
    }

    public function parameters()
    {
        return $this->parameters;
    }

    public function parameter($key)
    {
        return $this->parameters[$key];
    }
}
