<?php

namespace tests\units\JL\GlovoApi\Models;

use mageekguy\atoum as Units;
use JL\GlovoApi\Models\Customer as TestedModel;

class Customer extends Units\Test
{
    public function testConstruct()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($object = new TestedModel('fake-name', 'fake-mail', 'fake-city-code'))
            ->and($array = $object->toArray())
            ->string($array['name'])->isEqualTo('fake-name')
            ->string($array['email'])->isEqualTo('fake-mail')
            ->string($array['preferredCityCode'])->isEqualTo('fake-city-code')
            ->string($array['paymentWay'])->isEqualTo('MONTHLY')
        ;
    }
}
