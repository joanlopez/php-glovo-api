<?php

namespace tests\units\JL\GlovoApi;

use mageekguy\atoum as Units;
use JL\GlovoApi\GlovoApi as TestedInstance;

class GlovoApi extends Units\Test
{
    public function testConstruct()
    {
        $this->if($object = new TestedInstance('dummyId', 'dummySecret'))
            ->string($object->clientId())->isEqualTo('dummyId')
            ->string($object->clientSecret())->isEqualTo('dummySecret')
            ->integer($object->environment())->isEqualTo(TestedInstance::ENVIRONMENT_STAGE)
        ;
    }
}
