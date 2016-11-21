<?php

namespace JL\GlovoApi\HTTP;

class HttpResponse
{

    private $statusCode;
    private $statusPhrase;
    private $wasSuccessful;

    public function __construct($statusCode, $statusPhrase)
    {
        $this->statusCode = $statusCode;
        $this->statusPhrase = $statusPhrase;
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
}
