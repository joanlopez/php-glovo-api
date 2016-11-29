<?php

namespace tests\units\JL\GlovoApi;

use mageekguy\atoum as Units;
use JL\GlovoApi\GlovoApi as TestedInstance;
use JL\GlovoApi\Managers\CustomersManager;
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
}
