<?php

namespace tests\units\JL\GlovoApi;

use mageekguy\atoum as Units;
use JL\GlovoApi\GlovoApi as TestedInstance;
use JL\GlovoApi\Managers\CustomersManager;
use JL\GlovoApi\Managers\OrdersManager;
use JL\GlovoApi\HTTP\HttpResponse;

class GlovoApi extends Units\Test
{
    public function testConstruct()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockGenerator()->orphanize('login'))
            ->and($this->mockClass('\JL\GlovoApi\Managers\SessionManager', '\Mock'))
            ->and($mockSessionManager = new \mock\SessionManager())
            ->and($mockSessionManager->getMockController()->login = '1234')
            ->and($object = new TestedInstance ('dummyId', 'dummySecret', TestedInstance::ENVIRONMENT_STAGE, $mockSessionManager))
            ->string($object->clientId())->isEqualTo('dummyId')
            ->string($object->clientSecret())->isEqualTo('dummySecret')
            ->integer($object->environment())->isEqualTo(TestedInstance::ENVIRONMENT_STAGE)
            ->string($object->authToken())->isEqualTo('1234')
        ;
    }

    public function testLogout()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockGenerator()->orphanize('login'))
            ->and($this->mockGenerator()->orphanize('logout'))
            ->and($this->mockClass('\JL\GlovoApi\Managers\SessionManager', '\Mock'))
            ->and($mockSessionManager = new \mock\SessionManager())
            ->and($mockSessionManager->getMockController()->login = '1234')
            ->and($mockSessionManager->getMockController()->logout = true)
            ->and($object = new TestedInstance ('dummyId', 'dummySecret', TestedInstance::ENVIRONMENT_STAGE, $mockSessionManager))
            ->string($object->authToken())->isEqualTo('1234')
            ->when($object->close())
            ->then->variable($object->authToken())->isNull()
        ;
    }

    public function testGetCustomers()
    {
        $jsonString = '[{"id":15985,"urn":"glv:customer:fake","name":"fake-name","email":"fake-mail","passwordType":"BCRYPT","deviceUrn":null,"picture":null,"description":null,"deleted":false,"phoneNumber":null,"mediaSource":null,"mediaCampaign":null,"preferredLanguage":"en","sourceCompany":null,"sourceCompanyOrders":null,"paymentWay":"MONTHLY","paymentMethod":"BANK_TRANSFER","preferredCityCode":"BCN","os":null,"analyticsId":null,"sendInvoice":false,"enabled":true}]';
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockGenerator()->orphanize('login'))
            ->and($this->mockClass('\JL\GlovoApi\Managers\SessionManager', '\Mock'))
            ->and($mockSessionManager = new \mock\SessionManager())
            ->and($mockSessionManager->getMockController()->login = '1234')
            ->and($this->mockGenerator()->orphanize('getJsonAuthorized'))
            ->and($this->mockClass('\JL\GlovoApi\HTTP\HttpRequester', '\Mock'))
            ->and($httpRequesterMock = new \mock\HttpRequester())
            ->and($httpRequesterMock->getMockController()->getJsonAuthorized = new HttpResponse(200, 'OK', json_decode($jsonString)))
            ->and($customersManager = new CustomersManager($httpRequesterMock))
            ->and($object = new TestedInstance ('dummyId', 'dummySecret', TestedInstance::ENVIRONMENT_STAGE, $mockSessionManager, $customersManager))
            ->when($customers = $object->getCustomers())
            ->then->array($customers)->size->isEqualTo(1)
            ->and->variable($customers[0]->urn())->isEqualTo('glv:customer:fake')
            ->and->variable($customers[0]->name())->isEqualTo('fake-name')
            ->and->variable($customers[0]->email())->isEqualTo('fake-mail');
        ;
    }

    public function testGetCustomer()
    {
        $jsonString = '{"type":"Customer","id":15985,"urn":"glv:customer:fake","name":"fake-name","email":"fake-mail","passwordType":"BCRYPT","deviceUrn":null,"picture":null,"description":null,"deleted":false,"phoneNumber":null,"mediaSource":null,"mediaCampaign":null,"preferredLanguage":"en","sourceCompany":null,"sourceCompanyOrders":null,"paymentWay":"MONTHLY","paymentMethod":"BANK_TRANSFER","preferredCityCode":"BCN","os":null,"analyticsId":null,"sendInvoice":false,"enabled":true}';
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockGenerator()->orphanize('login'))
            ->and($this->mockClass('\JL\GlovoApi\Managers\SessionManager', '\Mock'))
            ->and($mockSessionManager = new \mock\SessionManager())
            ->and($mockSessionManager->getMockController()->login = '1234')
            ->and($this->mockGenerator()->orphanize('getJsonAuthorized'))
            ->and($this->mockClass('\JL\GlovoApi\HTTP\HttpRequester', '\Mock'))
            ->and($httpRequesterMock = new \mock\HttpRequester())
            ->and($httpRequesterMock->getMockController()->getJsonAuthorized = new HttpResponse(200, 'OK', json_decode($jsonString)))
            ->and($customersManager = new CustomersManager($httpRequesterMock))
            ->and($object = new TestedInstance ('dummyId', 'dummySecret', TestedInstance::ENVIRONMENT_STAGE, $mockSessionManager, $customersManager))
            ->when($customer = $object->getCustomer('glv:customer:fake'))
            ->then->variable($customer->urn())->isEqualTo('glv:customer:fake')
            ->and->variable($customer->name())->isEqualTo('fake-name')
            ->and->variable($customer->email())->isEqualTo('fake-mail')
            ->and->variable($customer->type())->isEqualTo('Customer');
        ;
    }

    public function testGetOrders()
    {
        $jsonString = '[{"urn": "glv:order:fake","creationTime": 1448544886000,"extraPoints": 0,"courierDiscount": 0,"usedBalance": 0,"code": "BPIRCOFP","description": "My first Order","total": null,"distance": null,"rating": null,"transport": null,"subtype": "SHIPMENT","scheduledTime": 2553081904000,"cityCode": "BCN","customer": {"type": "PartnerCustomer","urn": "glv:partnercustomer:752aaf8a-374d-4051-b9fb-9e01ba27127a","name": "First Customer","picture": null,"phoneNumber": {"number": "+34 611 000 000","countryCode": "ES"}},"courier": null,"points": [{"urn": "glv:point:40431870-1c65-4b3e-82ef-18d2fa1db65c","passed": false,"index": 0,"type": "PICKUP","address": {"urn": "glv:address:60729e32-50a5-4278-a773-7917e5644215","latitude": 41.40636,"longitude": 2.19217,"label": "Carrer Llacuna, 162 -164, 08018 Barcelona","details": "escalera A, planta 2, puerta 202"}}],"purchases": [],"attachments": [],"signature": null,"currentStatus": {"type": "ScheduledStatus","urn": "glv:scheduledstatus:305ff47e-31c1-4a48-819a-da078b5ed740"},"activationTime": null,"phoneNumber": "+34 611 000 000","pointFee": null,"tax": null}]';
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockGenerator()->orphanize('login'))
            ->and($this->mockClass('\JL\GlovoApi\Managers\SessionManager', '\Mock'))
            ->and($mockSessionManager = new \mock\SessionManager())
            ->and($mockSessionManager->getMockController()->login = '1234')
            ->and($this->mockGenerator()->orphanize('getJsonAuthorized'))
            ->and($this->mockClass('\JL\GlovoApi\HTTP\HttpRequester', '\Mock'))
            ->and($httpRequesterMock = new \mock\HttpRequester())
            ->and($httpRequesterMock->getMockController()->getJsonAuthorized = new HttpResponse(200, 'OK', json_decode($jsonString)))
            ->and($ordersManager = new OrdersManager($httpRequesterMock))
            ->and($object = new TestedInstance ('dummyId', 'dummySecret', TestedInstance::ENVIRONMENT_STAGE, $mockSessionManager, null, $ordersManager))
            ->when($orders = $object->getOrders('fake-token', 'fake-customer-urn'))
            ->then->array($orders)->size->isEqualTo(1)
            ->and->variable($orders[0]->urn())->isEqualTo('glv:order:fake')
            ->and->variable($orders[0]->cityCode())->isEqualTo('BCN')
            ->and->variable($orders[0]->subtype())->isEqualTo('SHIPMENT')
            ->and->variable($orders[0]->scheduledTime())->isEqualTo('2553081904000');
        ;
    }

    public function testGetOrder()
    {
        $jsonString = '{"urn": "glv:order:fake","creationTime": 1448544886000,"extraPoints": 0,"courierDiscount": 0,"usedBalance": 0,"code": "BPIRCOFP","description": "My first Order","total": null,"distance": null,"rating": null,"transport": null,"subtype": "SHIPMENT","scheduledTime": 2553081904000,"cityCode": "BCN","customer": {"type": "PartnerCustomer","urn": "glv:partnercustomer:752aaf8a-374d-4051-b9fb-9e01ba27127a","name": "First Customer","picture": null,"phoneNumber": {"number": "+34 611 000 000","countryCode": "ES"}},"courier": null,"points": [{"urn": "glv:point:40431870-1c65-4b3e-82ef-18d2fa1db65c","passed": false,"index": 0,"type": "PICKUP","address": {"urn": "glv:address:60729e32-50a5-4278-a773-7917e5644215","latitude": 41.40636,"longitude": 2.19217,"label": "Carrer Llacuna, 162 -164, 08018 Barcelona","details": "escalera A, planta 2, puerta 202"}}],"purchases": [],"attachments": [],"signature": null,"currentStatus": {"type": "ScheduledStatus","urn": "glv:scheduledstatus:305ff47e-31c1-4a48-819a-da078b5ed740"},"activationTime": null,"phoneNumber": "+34 611 000 000","pointFee": null,"tax": null}';
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockGenerator()->orphanize('login'))
            ->and($this->mockClass('\JL\GlovoApi\Managers\SessionManager', '\Mock'))
            ->and($mockSessionManager = new \mock\SessionManager())
            ->and($mockSessionManager->getMockController()->login = '1234')
            ->and($this->mockGenerator()->orphanize('getJsonAuthorized'))
            ->and($this->mockClass('\JL\GlovoApi\HTTP\HttpRequester', '\Mock'))
            ->and($httpRequesterMock = new \mock\HttpRequester())
            ->and($httpRequesterMock->getMockController()->getJsonAuthorized = new HttpResponse(200, 'OK', json_decode($jsonString)))
            ->and($ordersManager = new OrdersManager($httpRequesterMock))
            ->and($object = new TestedInstance ('dummyId', 'dummySecret', TestedInstance::ENVIRONMENT_STAGE, $mockSessionManager, null, $ordersManager))
            ->when($order = $object->getOrder('glv:customer:fake', 'glv:order:fake'))
            ->and->variable($order->urn())->isEqualTo('glv:order:fake')
            ->and->variable($order->cityCode())->isEqualTo('BCN')
            ->and->variable($order->subtype())->isEqualTo('SHIPMENT')
            ->and->variable($order->scheduledTime())->isEqualTo('2553081904000');
        ;
    }
}
