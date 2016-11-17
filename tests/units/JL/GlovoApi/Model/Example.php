<?php

namespace tests\units\JL\GlovoApi\Model;

use mageekguy\atoum as Units;
//use JL\GlovoApi\Model\Device as TestedModel;

class Example extends Units\Test
{
    public function testExample()
    {
        $this->if($object = 'hello-world')
            ->string($object)->isEqualTo('hello-world')
        ;
    }
}
