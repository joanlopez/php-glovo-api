<?php

namespace JL\GlovoApi\Managers;

use JL\GlovoApi\HTTP\HttpRequester;
use JL\GlovoApi\Models\Order;

class OrdersManager
{

    const GET_ORDERS = 'v1/customers/%s/orders';
    const GET_ORDER = 'v1/customers/%s/orders/%s';

    private $httpRequester;

    public function __construct($httpRequester = null)
    {
        $this->httpRequester = (is_null($httpRequester)) ? new HttpRequester() : $httpRequester;
    }

    public function getOrders($clientToken, $customerUrn)
    {
        $url = sprintf(self::GET_ORDERS, $customerUrn);
        $response = $this->httpRequester->getJsonAuthorized($url, $clientToken);

        $orders = array();
        if(!$response->wasSuccessful()) return $orders;

        foreach($response->parameters() as $order_data)
        {
            $tmp_order = new Order(
                $order_data->{'cityCode'},
                $order_data->{'points'}
            );
            if(!is_null($order_data->{'urn'}))
                $tmp_order->setUrn($order_data->{'urn'});
            if(!is_null($order_data->{'description'}))
                $tmp_order->setDescription($order_data->{'description'});
            if(!is_null($order_data->{'scheduledTime'}))
                $tmp_order->setScheduledTime($order_data->{'scheduledTime'});
            if(!is_null($order_data->{'subtype'}))
                $tmp_order->setSubtype($order_data->{'subtype'});
            if(!is_null($order_data->{'phoneNumber'}))
                $tmp_order->setPhoneNumber($order_data->{'phoneNumber'});
            array_push($orders, $tmp_order);
        }

        return $orders;
    }

    public function getOrder($clientToken, $customerUrn, $orderUrn)
    {
        $url = sprintf(self::GET_ORDER, $customerUrn, $orderUrn);
        $response = $this->httpRequester->getJsonAuthorized($url, $clientToken);

        if(!$response->wasSuccessful()) return null;
        $tmp_order = new Order(
            $response->parameters()->{'cityCode'},
            $response->parameters()->{'points'}
        );
        if(!is_null($response->parameters()->{'urn'}))
            $tmp_order->setUrn($response->parameters()->{'urn'});
        if(!is_null($response->parameters()->{'description'}))
            $tmp_order->setDescription($response->parameters()->{'description'});
        if(!is_null($response->parameters()->{'scheduledTime'}))
            $tmp_order->setScheduledTime($response->parameters()->{'scheduledTime'});
        if(!is_null($response->parameters()->{'subtype'}))
            $tmp_order->setSubtype($response->parameters()->{'subtype'});
        if(!is_null($response->parameters()->{'phoneNumber'}))
            $tmp_order->setPhoneNumber($response->parameters()->{'phoneNumber'});

        return $tmp_order;
    }


}
