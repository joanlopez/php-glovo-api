<?php

namespace JL\GlovoApi;

use JL\GlovoApi\Managers\SessionManager;
use JL\GlovoApi\Managers\CustomersManager;
use JL\GlovoApi\Managers\OrdersManager;

class GlovoApi
{
    const ENVIRONMENT_STAGE  = 1;
    const ENVIRONMENT_PRODUCTION = 2;

    private $environment;
    private $clientId;
    private $clientSecret;
    private $authToken;

    private $sessionManager;
    private $customersManager;
    private $ordersManager;

    public function __construct($clientId,
                                $clientSecret,
                                $environment = self::ENVIRONMENT_STAGE,
                                $sessionManager = null,
                                $customersManager = null,
                                $ordersManager = null)
    {
        $this->environment = $environment;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->authToken = null;

        $this->sessionManager = (is_null($sessionManager)) ? new SessionManager() : $sessionManager;
        $this->customersManager = (is_null($customersManager)) ? new CustomersManager() : $customersManager;
        $this->ordersManager = (is_null($ordersManager)) ? new OrdersManager() : $ordersManager;

        $this->authToken = $this->sessionManager->login($this->clientId, $this->clientSecret);
    }

    public function environment()
    {
        return $this->environment;
    }

    public function clientId()
    {
        return $this->clientId;
    }

    public function clientSecret()
    {
        return $this->clientSecret;
    }

    public function authToken()
    {
        return $this->authToken;
    }

    public function close()
    {
        if($this->sessionManager->logout($this->authToken))
            $this->authToken = null;
        else
            throw new \Exception('Error occurred while logging out');
    }

    public function getCustomers()
    {
        return $this->customersManager->getCustomers($this->authToken());
    }

    public function getCustomer($customerUrn)
    {
        return $this->customersManager->getCustomer($this->authToken(), $customerUrn);
    }

    public function getOrders($customerUrn)
    {
        return $this->ordersManager->getOrders($this->authToken(), $customerUrn);
    }

    public function getOrder($customerUrn, $orderUrn)
    {
        return $this->ordersManager->getOrder($this->authToken(), $customerUrn, $orderUrn);
    }

    public function createOrder($customerUrn, $description, $cityCode, $address, $addressType, $subtype)
    {
        return $this->ordersManager->createOrder($this->authToken(), $customerUrn, $description, $cityCode, $address, $addressType, $subtype);
    }
}
