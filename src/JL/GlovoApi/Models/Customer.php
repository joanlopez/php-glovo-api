<?php

namespace JL\GlovoApi\Models;

class Customer
{
    private $urn;

    private $name;
    private $email;
    private $preferredCityCode;
    private $description;


    public function __construct($name, $email, $preferredCityCode, $description)
    {
        $this->name = $name;
        $this->email = $email;
        $this->preferredCityCode = $preferredCityCode;
        $this->description = $description;

        $this->urn = null;
    }

    public function name()
    {
        return $this->name;
    }

    public function email()
    {
        return $this->email;
    }

    public function preferredCityCode()
    {
        return $this->preferredCityCode;
    }

    public function description()
    {
        return $this->description;
    }

    public function urn()
    {
        return $this->urn;
    }

    public function setUrn($urn)
    {
        $this->urn = $urn;
    }
}