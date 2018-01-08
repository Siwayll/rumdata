<?php

namespace Siwayll\RumData\Specs\Units;

use mageekguy\atoum;
use mageekguy\atoum\mock;

abstract class Test extends atoum\spec
{
    public function beforeTestMethod($method)
    {
        mock\controller::disableAutoBindForNewMock();

        $this->mockGenerator
            ->allIsInterface()
            ->eachInstanceIsUnique()
        ;

        return parent::beforeTestMethod($method);
    }
}
