<?php

namespace JL\GlovoApi\Managers;

use JL\GlovoApi\HTTP\HttpRequester;
use JL\GlovoApi\Models\Order;

class OrdersManager
{

    const GET_ORDERS = 'v1/customers/%s/orders';
    const GET_ORDER = 'v1/customers/%s/orders/%s';
    const POST_ORDER = 'v1/customers/%s/orders';

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
        if (!$response->wasSuccessful()) return $orders;
        foreach ($response->parameters() as $order_data) {
            $tmp_order = $this->createOrderModel($order_data);
            array_push($orders, $tmp_order);
        }
        return $orders;
    }

    public function getOrder($clientToken, $customerUrn, $orderUrn)
    {
        $url = sprintf(self::GET_ORDER, $customerUrn, $orderUrn);
        $response = $this->httpRequester->getJsonAuthorized($url, $clientToken);
        if (!$response->wasSuccessful()) return null;
        $tmp_order = $this->createOrderModel($response->parameters());
        return $tmp_order;
    }

    public function createOrder($clientToken, $customerUrn, $description, $cityCode, $points, $subtype)
    {
        $url = sprintf(self::POST_ORDER, $customerUrn);
        $parameters = $this->createOrderRequestData($description, $cityCode, $points, $subtype);
        $response = $this->httpRequester->postJsonAuthorized($url, $clientToken, $parameters);
        if (!$response->wasSuccessful()) return null;
        $tmp_order = $this->createOrderModel($response->parameters());
        return $tmp_order;
    }

    private function createOrderModel($order_data)
    {
        $tmp_order = new Order(
            $order_data['customer']['urn'],
            $order_data['description'],
            $order_data['cityCode'],
            $order_data['subtype'],
            $order_data['points'][0]['address']['label'],
            $order_data['points'][0]['type']
        );
        if (!is_null($order_data['urn']))
            $tmp_order->setUrn($order_data['urn']);

        return $tmp_order;
    }

    private function createOrderRequestData($description, $cityCode, $points, $subtype)
    {
        $points_data = array();
        foreach($points as $point)
        {
            $point_data = array(
                'address' => array('label' => $point['address']),
                'type' => $point['type']
            );
            array_push($points_data, $point_data);
        }
        $parameters = array();
        $parameters['description'] = $description;
        $parameters['cityCode'] = $cityCode;
        $parameters['points'] = $points_data;
        $parameters['subtype'] = $subtype;
        return $parameters;
    }


}
