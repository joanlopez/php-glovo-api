<?php

namespace tests\units\JL\GlovoApi;

use mageekguy\atoum as Units;
use JL\GlovoApi\GlovoApi as TestedInstance;

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
}
