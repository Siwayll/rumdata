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
        ;
    }

    public function shouldAcceptIntegerKey()
    {
        $this
            ->given($this->newTestedInstance())
            ->object($this->testedInstance->set(500, 1))
                ->isTestedInstance()
            ->integer($this->testedInstance->get(1))
                ->isEqualTo(500)
            ->object($this->testedInstance->set(500, 10, 20))
                ->isTestedInstance()
            ->boolean($this->testedInstance->has(10, 20))
                ->isTrue()
            ->integer($this->testedInstance->get(10, 20))
                ->isEqualTo(500)
            ->object($this->testedInstance->kill(10, 20))
                ->isTestedInstance()
            ->boolean($this->testedInstance->has(10, 20))
                ->isFalse()
            ->boolean($this->testedInstance->has(10))
                ->isTrue()
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

    public function shouldKnowIfAPartOfRumdataIsAList()
    {
        $this
            ->given(
                $data = 500,
                $list = $this->newTestedInstance(),
                $this->testedInstance->set($data, 0),
                $this->testedInstance->set($data, 1),
                $this->testedInstance->set($data, 2),
                $this->testedInstance->set($data, 3),
                $smallList = $this->newTestedInstance(),
                $smallList->set('one', 0),
                $smallList->set('two', 1),
                $smallList->set('three', 2)
            )
            ->boolean($this->testedInstance->isAList())
                ->isTrue()
            ->if($list->set($smallList, 'custom', 'field'))
            ->boolean($list->isAList())
                ->isFalse()
            ->boolean($list->isAList('custom'))
                ->isFalse()
            ->boolean($list->isAList('custom', 'field'))
                ->isTrue()
        ;
    }

    public function shouldBeCapableOfAppendDataInAList()
    {
        $this
            ->given(
                $data = 500,
                $rumData = $this->newTestedInstance(),
                $smallList = $this->newTestedInstance(),
                $smallList->set('one', 0),
                $smallList->set('two', 1),
                $smallList->set('three', 2),
                $foo = $this->newTestedInstance(),
                $foo->set('value', 'key')
            )
            ->if($rumData->set($smallList, 'custom', 'field'))
            ->boolean($rumData->isAList('custom', 'field'))
                ->isTrue()
            ->if($rumData->append($foo, 'custom', 'field'))
            ->boolean($rumData->isAList('custom', 'field'))
                ->isTrue()
            ->array((array) $rumData->get('custom', 'field'))
                ->variable[3]->isEqualTo($foo)
        ;
    }
}
