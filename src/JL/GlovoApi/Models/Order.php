<?php

namespace JL\GlovoApi\Models;

class Order
{
    private $urn;

    private $customerUrn;
    private $description;
    private $cityCode;
    private $subtype;
    private $address;
    private $addressType;

    public function __construct($customerUrn, $description, $cityCode, $subtype, $address, $addressType)
    {
        $this->customerUrn = $customerUrn;
        $this->description = $description;
        $this->cityCode = $cityCode;
        $this->subtype = $subtype;
        $this->address = $address;
        $this->addressType = $addressType;

        $this->urn = null;
    }

    public function customerUrn()
    {
        return $this->customerUrn;
    }

    public function description()
    {
        return $this->description;
    }

    public function cityCode()
    {
        return $this->cityCode;
    }

    public function subtype()
    {
        return $this->subtype;
    }

    public function address()
    {
        return $this->address;
    }

    public function addressType()
    {
        return $this->addressType;
    }

    public function urn()
    {
        return $this->urn;
    }

    public function setUrn($urn)
    {
        $this->urn = $urn;
    }

    public function setSubtype($subtype)
    {
        $this->subtype = $subtype;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }
}