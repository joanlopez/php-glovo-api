<?php

namespace JL\GlovoApi\Models;

class Order
{
    private $urn;

    private $cityCode;
    private $points;
    private $type;

    private $description;
    private $phoneNumber;
    private $scheduledTime;
    private $subtype;


    public function __construct($cityCode, $points, $type='Order')
    {
        $this->cityCode = $cityCode;
        $this->points = $points;
        $this->type = $type;

        $this->urn = null;
        $this->description = null;
        $this->phoneNumber = null;
        $this->scheduledTime = null;
        $this->subtype = null;
    }

    public function cityCode()
    {
        return $this->cityCode;
    }

    public function points()
    {
        return $this->points;
    }

    public function type()
    {
        return $this->type;
    }

    public function subtype()
    {
        return $this->subtype;
    }

    public function scheduledTime()
    {
        return $this->scheduledTime;
    }

    public function urn()
    {
        return $this->urn;
    }

    public function setUrn($urn)
    {
        $this->urn = $urn;
    }

    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function setType($type='Order')
    {
        $this->type = $type;
    }

    public function setSubtype($subtype)
    {
        $this->subtype = $subtype;
    }

    public function setScheduledTime($scheduledTime)
    {
        $this->scheduledTime = $scheduledTime;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function toArray()
    {
        $data =
        [
            'cityCode' => $this->cityCode,
            'points' => $this->points,
            'type' => $this->type,
        ];
        if(!is_null($this->urn)) $data += ['urn' => $this->urn];
        if(!is_null($this->description)) $data += ['description' => $this->description];
        if(!is_null($this->scheduledTime)) $data += ['scheduledTime' => $this->scheduledTime];
        if(!is_null($this->subtype)) $data += ['subtype' => $this->subtype];
        if(!is_null($this->phoneNumber)) $data += ['phoneNumber' => $this->phoneNumber];
        return $data;
    }
}