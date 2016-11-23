<?php

namespace tests\units\JL\GlovoApi\Managers;

use mageekguy\atoum as Units;
use JL\GlovoApi\Managers\SessionManager as TestedManager;
use JL\GlovoApi\HTTP\HttpResponse;

class SessionManager extends Units\Test
{
    public function testLogin()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockGenerator()->orphanize('postJson'))
            ->and($this->mockClass('\JL\GlovoApi\HTTP\HttpRequester', '\Mock'))
            ->and($httpRequesterMock = new \mock\HttpRequester())
            ->and($httpRequesterMock->getMockController()->postJson = new HttpResponse(200, 'OK', array('token'=>'1234')))
            ->and($object = new TestedManager($httpRequesterMock))
            ->string($object->login('fake-id', 'fake-secret'))->isEqualTo('1234')
        ;
    }

    public function testLogout()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockGenerator()->orphanize('deleteAuthorization'))
            ->and($this->mockClass('\JL\GlovoApi\HTTP\HttpRequester', '\Mock'))
            ->and($httpRequesterMock = new \mock\HttpRequester())
            ->and($httpRequesterMock->getMockController()->deleteAuthorization = new HttpResponse(200, 'OK', array()))
            ->and($object = new TestedManager($httpRequesterMock))
            ->boolean($object->logout('fake-token'))->isEqualTo(true)
        ;
    }
}
