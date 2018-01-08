<?php

use mageekguy\atoum\bdd;

$extension = new bdd\extension($script);
$runner->addExtension($extension);

$runner
    ->addTestsFromDirectory(__DIR__ . '/specs/units/')
    ->disallowUsageOfUndefinedMethodInMock()
;
