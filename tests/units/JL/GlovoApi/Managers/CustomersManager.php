<?php

namespace tests\units\JL\GlovoApi\Managers;

use mageekguy\atoum as Units;
use JL\GlovoApi\Managers\CustomersManager as TestedManager;
use JL\GlovoApi\HTTP\HttpResponse;

class CustomersManager extends Units\Test
{
    public function testGetCustomers()
    {
        $jsonString = '[{"id":15985,"urn":"glv:customer:fake","name":"fake-name","email":"fake-mail","passwordType":"BCRYPT","deviceUrn":null,"picture":null,"description":null,"deleted":false,"phoneNumber":null,"mediaSource":null,"mediaCampaign":null,"preferredLanguage":"en","sourceCompany":null,"sourceCompanyOrders":null,"paymentWay":"MONTHLY","paymentMethod":"BANK_TRANSFER","preferredCityCode":"BCN","os":null,"analyticsId":null,"sendInvoice":false,"enabled":true}]';
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockGenerator()->orphanize('getJsonAuthorized'))
            ->and($this->mockClass('\JL\GlovoApi\HTTP\HttpRequester', '\Mock'))
            ->and($httpRequesterMock = new \mock\HttpRequester())
            ->and($httpRequesterMock->getMockController()->getJsonAuthorized = new HttpResponse(200, 'OK', json_decode($jsonString, true)))
            ->and($object = new TestedManager($httpRequesterMock))
            ->when($customers = $object->getCustomers('fake-token'))
            ->then->array($customers)->size->isEqualTo(1)
            ->and->variable($customers[0]->urn())->isEqualTo('glv:customer:fake')
            ->and->variable($customers[0]->name())->isEqualTo('fake-name')
            ->and->variable($customers[0]->email())->isEqualTo('fake-mail');
        ;
    }
}
