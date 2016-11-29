<?php

namespace JL\GlovoApi\Models;

class Customer
{
    private $urn;

    private $name;
    private $password;
    private $email;

    private $type;
    private $paymentWay;
    private $preferredCityCode;

    private $picture;
    private $description;


    public function __construct($name, $email, $preferredCityCode, $paymentWay='MONTHLY')
    {
        $this->name = $name;
        $this->email = $email;
        $this->preferredCityCode = $preferredCityCode;
        $this->paymentWay = $paymentWay;

        $this->urn = null;
        $this->password = null;
        $this->type = null;
        $this->picture = null;
        $this->description = null;
    }

    public function name()
    {
        return $this->name;
    }

    public function email()
    {
        return $this->email;
    }

    public function type()
    {
        return $this->type;
    }

    public function urn()
    {
        return $this->urn;
    }

    public function setUrn($urn)
    {
        $this->urn = $urn;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setType($type='PartnerCustomer')
    {
        $this->type = $type;
    }

    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function toArray()
    {
        $data =
        [
            'name' => $this->name,
            'email' => $this->email,
            'preferredCityCode' => $this->preferredCityCode,
            'paymentWay' => $this->paymentWay
        ];
        if(!is_null($this->urn)) $data += ['urn' => $this->urn];
        if(!is_null($this->password)) $data += ['password' => $this->password];
        if(!is_null($this->type)) $data += ['type' => $this->type];
        if(!is_null($this->picture)) $data += ['picture' => $this->picture];
        if(!is_null($this->description)) $data += ['description' => $this->description];
        return $data;
    }
}