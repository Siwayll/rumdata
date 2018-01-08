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
}
