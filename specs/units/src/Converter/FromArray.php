<?php

namespace Siwayll\RumData\Specs\Units\Converter;

use Siwayll\RumData\Specs\Units\Test;
use Siwayll\RumData\RumData;
use Siwayll\RumData\Converter\FromArray as TestedClass;

class FromArray extends Test
{

    public function dataProvider()
    {
        $secondTest = new RumData();
        $secondTest->set('value', 'key');

        $thirdTest = new RumData();
        $thirdTest->set('value', 'anotherKey');
        $foo = new RumData();
        $foo->set('value', 'secondKey');
        $thirdTest->set($foo, 'key');
        return [
            [
                [],
                new RumData()
            ],
            [
                ['key' => 'value'],
                $secondTest
            ],
            [
                ['key' => ['secondKey' => 'value'], 'anotherKey' => 'value'],
                $thirdTest
            ],
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function shouldConvertArray($array, $rumData)
    {
        $this
            ->object(TestedClass::toRumData($array))
                ->isEqualTo($rumData)
        ;
    }
}

