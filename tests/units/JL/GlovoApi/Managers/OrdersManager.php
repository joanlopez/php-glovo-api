<?php

namespace tests\units\JL\GlovoApi\Managers;

use mageekguy\atoum as Units;
use JL\GlovoApi\Managers\OrdersManager as TestedManager;
use JL\GlovoApi\HTTP\HttpResponse;

class OrdersManager extends Units\Test
{
    public function testGetOrders()
    {
        $jsonString = '[{"urn": "glv:customer:fake","creationTime": 1448544886000,"extraPoints": 0,"courierDiscount": 0,"usedBalance": 0,"code": "BPIRCOFP","description": "My first Order","total": null,"distance": null,"rating": null,"transport": null,"subtype": "SHIPMENT","scheduledTime": 2553081904000,"cityCode": "BCN","customer": {"type": "PartnerCustomer","urn": "glv:partnercustomer:752aaf8a-374d-4051-b9fb-9e01ba27127a","name": "First Customer","picture": null,"phoneNumber": {"number": "+34 611 000 000","countryCode": "ES"}},"courier": null,"points": [{"urn": "glv:point:40431870-1c65-4b3e-82ef-18d2fa1db65c","passed": false,"index": 0,"type": "PICKUP","address": {"urn": "glv:address:60729e32-50a5-4278-a773-7917e5644215","latitude": 41.40636,"longitude": 2.19217,"label": "Carrer Llacuna, 162 -164, 08018 Barcelona","details": "escalera A, planta 2, puerta 202"}}],"purchases": [],"attachments": [],"signature": null,"currentStatus": {"type": "ScheduledStatus","urn": "glv:scheduledstatus:305ff47e-31c1-4a48-819a-da078b5ed740"},"activationTime": null,"phoneNumber": "+34 611 000 000","pointFee": null,"tax": null}]';
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockGenerator()->orphanize('getJsonAuthorized'))
            ->and($this->mockClass('\JL\GlovoApi\HTTP\HttpRequester', '\Mock'))
            ->and($httpRequesterMock = new \mock\HttpRequester())
            ->and($httpRequesterMock->getMockController()->getJsonAuthorized = new HttpResponse(200, 'OK', json_decode($jsonString, true)))
            ->and($object = new TestedManager($httpRequesterMock))
            ->when($orders = $object->getOrders('fake-token', 'fake-customer-urn'))
            ->then->array($orders)->size->isEqualTo(1)
            ->and->variable($orders[0]->urn())->isEqualTo('glv:customer:fake')
            ->and->variable($orders[0]->cityCode())->isEqualTo('BCN')
            ->and->variable($orders[0]->subtype())->isEqualTo('SHIPMENT');
        ;
    }
}
