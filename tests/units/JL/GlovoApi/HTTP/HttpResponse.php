<?php

namespace tests\units\JL\GlovoApi\HTTP;

use mageekguy\atoum as Units;
use JL\GlovoApi\HTTP\HttpResponse as TestedModel;

class HttpResponse extends Units\Test
{
    public function testSuccessfulConstruct()
    {
        $this->if($object = new TestedModel(200, 'dummy phrase'))
            ->integer($object->statusCode())->isEqualTo(200)
            ->string($object->statusPhrase())->isEqualTo('dummy phrase')
            ->boolean($object->wasSuccessful())->isEqualTo(true)
        ;
    }

    public function testUnsuccessfulConstruct()
    {
        $this->if($object = new TestedModel(400, 'dummy phrase'))
            ->integer($object->statusCode())->isEqualTo(400)
            ->string($object->statusPhrase())->isEqualTo('dummy phrase')
            ->boolean($object->wasSuccessful())->isEqualTo(false)
        ;
    }
}
