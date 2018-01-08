<?php

namespace Siwayll\RumData\Specs\Units;

class RumData extends Test
{
    public function shouldStoreDataAtAnyDepthLevel()
    {
        $this
            ->given($this->newTestedInstance())
            ->object($this->testedInstance->set(500, 'varName'))
                ->isTestedInstance()
            ->integer($this->testedInstance->get('varName'))
                ->isEqualTo(500)
            ->object($this->testedInstance->set(500, 'depth1', 'depth2'))
                ->isTestedInstance()
            ->boolean($this->testedInstance->has('depth1', 'depth2'))
                ->isTrue()
            ->integer($this->testedInstance->get('depth1', 'depth2'))
                ->isEqualTo(500)
            ->object($this->testedInstance->kill('depth1', 'depth2'))
                ->isTestedInstance()
            ->boolean($this->testedInstance->has('depth1', 'depth2'))
                ->isFalse()
            ->boolean($this->testedInstance->has('depth1'))
                ->isTrue()
            ->dump($this->testedInstance)
        ;
    }

    public function shouldBeUseAsAnArray()
    {
        $this
            ->given(
                $data = 500,
                $this->newTestedInstance(),
                $this->testedInstance->set($data, 'name')
            )
            ->testedClass
                ->hasInterface('\ArrayAccess')
            ->assert('it should test if field exists normaly')
                ->boolean(isset($this->testedInstance['name']))
                    ->isTrue()
                ->boolean(isset($this->testedInstance['falseName']))
                    ->isFalse()
            ->assert('it should return data normaly')
                ->integer($this->testedInstance['name'])
                    ->isEqualTo($data)
                ->variable($this->testedInstance['falsField'])
                    ->isNull()

            ->assert('it should agree to create a new field')
                ->given($this->testedInstance['customField'] = 'foo')
                ->string($this->testedInstance['customField'])
                    ->isEqualTo('foo')
                ->boolean(isset($this->testedInstance['customField']))
                    ->isTrue()

            ->assert('it should unset data normaly')
                ->given($this->testedInstance['customField'] = 'foo')
                ->boolean(isset($this->testedInstance['customField']))
                    ->isTrue()
                ->when(
                    function () {
                        unset($this->testedInstance['customField']);
                    }
                )
                ->boolean(isset($this->testedInstance['customField']))
                    ->isFalse()
        ;
    }
}
