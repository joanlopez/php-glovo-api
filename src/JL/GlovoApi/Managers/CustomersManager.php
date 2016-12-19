<?php

namespace JL\GlovoApi\Managers;

use JL\GlovoApi\HTTP\HttpRequester;
use JL\GlovoApi\Models\Customer;

class CustomersManager 
{
    const GET_CUSTOMERS = 'v1/users';
    const GET_CUSTOMER = 'v1/users/%s';
    const POST_CUSTOMER = 'v1/customers';

    private $httpRequester;

    public function __construct($httpRequester = null)
    {
        $this->httpRequester = (is_null($httpRequester)) ? new HttpRequester() : $httpRequester;
    }

    public function getCustomers($clientToken)
    {
        $response = $this->httpRequester->getJsonAuthorized(self::GET_CUSTOMERS, $clientToken);
        $customers = array();
        if(!$response->wasSuccessful()) return $customers;
        foreach($response->parameters() as $customer_data)
        {
            $tmp_customer = $this->createCustomerModel($customer_data);
            array_push($customers, $tmp_customer);
        }
        return $customers;
    }

    public function getCustomer($clientToken, $customerUrn)
    {
        $url = sprintf(self::GET_CUSTOMER, $customerUrn);
        $response = $this->httpRequester->getJsonAuthorized($url, $clientToken);
        if(!$response->wasSuccessful()) return null;
        $tmp_customer = $this->createCustomerModel($response->parameters());
        return $tmp_customer;
    }

    public function createCustomer($clientToken, $description, $preferredCityCode, $name, $email)
    {
        $parameters = $this->createCustomerRequestData($description, $preferredCityCode, $name, $email);
        $response = $this->httpRequester->postJsonAuthorized(self::POST_CUSTOMER, $clientToken, $parameters);
        if (!$response->wasSuccessful()) return null;
        $tmp_order = $this->createCustomerModel($response->parameters());
        return $tmp_order;
    }

    private function createCustomerModel($customer_data)
    {
        $tmp_customer = new Customer(
            $customer_data['name'],
            $customer_data['email'],
            $customer_data['preferredCityCode'],
            $customer_data['description']
        );
        if (!is_null($customer_data['urn']))
            $tmp_customer->setUrn($customer_data['urn']);

        return $tmp_customer;
    }

    private function createCustomerRequestData($description, $preferredCityCode, $name, $email)
    {
        $parameters = array();
        $parameters['description'] = $description;
        $parameters['password'] = $description;
        $parameters['preferredCityCode'] = $preferredCityCode;
        $parameters['name'] = $name;
        $parameters['email'] = $email;
        return $parameters;
    }
}
