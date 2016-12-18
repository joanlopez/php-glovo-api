<?php

namespace tests\units\JL\GlovoApi\Models;

use mageekguy\atoum as Units;
use JL\GlovoApi\Models\Order as TestedModel;

class Order extends Units\Test
{
    public function testConstruct()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($object = new TestedModel('fake-customer-urn', 'fake-description', 'fake-city-code', 'fake-subtype', 'fake-address', 'fake-address-type'))
            ->and($object->setUrn('fake-urn'))
            ->string($object->customerUrn())->isEqualTo('fake-customer-urn')
            ->string($object->description())->isEqualTo('fake-description')
            ->string($object->cityCode())->isEqualTo('fake-city-code')
            ->string($object->subtype())->isEqualTo('fake-subtype')
            ->string($object->address())->isEqualTo('fake-address')
            ->string($object->addressType())->isEqualTo('fake-address-type')
            ->string($object->urn())->isEqualTo('fake-urn');
    }
}
