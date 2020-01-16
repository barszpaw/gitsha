<?php

namespace App\Tests\Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Acceptance extends \Codeception\Module
{
    public function getSymfonyKernel()
    {
        $symfony = parent::getModule('Symfony');
        return $symfony->kernel;
    }

}
