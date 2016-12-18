<?php

namespace tests\units\JL\GlovoApi\Models;

use mageekguy\atoum as Units;
use JL\GlovoApi\Models\Customer as TestedModel;

class Customer extends Units\Test
{
    public function testConstruct()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($object = new TestedModel('fake-name', 'fake-mail', 'fake-city-code', 'fake-description'))
            ->and($object->setUrn('fake-urn'))
            ->string($object->name())->isEqualTo('fake-name')
            ->string($object->email())->isEqualTo('fake-mail')
            ->string($object->preferredCityCode())->isEqualTo('fake-city-code')
            ->string($object->description())->isEqualTo('fake-description')
            ->string($object->urn())->isEqualTo('fake-urn');
    }
}
