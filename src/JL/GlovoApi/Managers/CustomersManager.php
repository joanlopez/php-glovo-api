<?php

namespace JL\GlovoApi\Managers;

use JL\GlovoApi\HTTP\HttpRequester;
use JL\GlovoApi\Models\Customer;

class CustomersManager 
{
    const GET_USERS = 'v1/users';

    private $httpRequester;

    public function __construct($httpRequester = null)
    {
        $this->httpRequester = (is_null($httpRequester)) ? new HttpRequester() : $httpRequester;
    }

    public function getCustomers($clientToken)
    {
        $response = $this->httpRequester->getJsonAuthorized(self::GET_USERS, $clientToken);

        $customers = array();
        if(!$response->wasSuccessful()) return $customers;

        foreach($response->parameters() as $customer_data)
        {
            $tmp_customer = new Customer(
                $customer_data->{'name'},
                $customer_data->{'email'},
                $customer_data->{'preferredCityCode'}
            );
            if(!is_null($customer_data->{'urn'}))
                $tmp_customer->setUrn($customer_data->{'urn'});
            if(!is_null($customer_data->{'picture'}))
                $tmp_customer->setPicture($customer_data->{'picture'});
            if(!is_null($customer_data->{'urn'}))
                $tmp_customer->setDescription($customer_data->{'description'});
            array_push($customers, $tmp_customer);
        }

        return $customers;
    }

    public function getCustomer($clientToken, $urn)
    {
        $url = self::GET_USERS.'/'.$urn;
        $response = $this->httpRequester->getJsonAuthorized($url, $clientToken);

        if(!$response->wasSuccessful()) return null;
        $tmp_customer = new Customer(
            $response->parameters()->{'name'},
            $response->parameters()->{'email'},
            $response->parameters()->{'preferredCityCode'}
        );
        if(!is_null($response->parameters()->{'urn'}))
            $tmp_customer->setUrn($response->parameters()->{'urn'});
        if(!is_null($response->parameters()->{'type'}))
            $tmp_customer->setType($response->parameters()->{'type'});
        if(!is_null($response->parameters()->{'picture'}))
            $tmp_customer->setPicture($response->parameters()->{'picture'});
        if(!is_null($response->parameters()->{'description'}))
            $tmp_customer->setDescription($response->parameters()->{'description'});

        return $tmp_customer;
    }
}
