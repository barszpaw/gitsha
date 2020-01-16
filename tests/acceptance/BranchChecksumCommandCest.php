<?php

namespace App\Tests;


use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class BranchChecksumCommandCest
{

  public function UnknownServiceTest(AcceptanceTester $I)
    {
        $I->wantTo('Check for unknown vsc service given');

        /** @var \App\Kernel $kernel */
        $kernel = $I->getSymfonyKernel();
        $kernel->boot();
        $application = new Application($kernel);
        $command = $application->find('app:branch:checksum');

        $commandTester = new CommandTester($command);
        //app:branch:checksum php-fig/log master -s api.github.com
        $commandTester->execute([
            'repository' => 'php-fig/log',
            'branch' => 'master',
            '--service' => 'alal'
        ]);
        $output = $commandTester->getDisplay();

        $I->assertEquals("Unknown service 'alal'\n", $output);


    }

    public function BranchNotFoundTest(AcceptanceTester $I)
    {
        $I->wantTo('Check for unknown Branch given');

        /** @var \App\Kernel $kernel */
        $kernel = $I->getSymfonyKernel();
        $kernel->boot();
        $application = new Application($kernel);
        $command = $application->find('app:branch:checksum');
        $commandTester = new CommandTester($command);
        //app:branch:checksum php-fig/log master -s api.github.com
        $commandTester->execute([
            'repository' => 'php-fig/log',
            'branch' => 'master1',
            '--service' => 'api.github.com'
        ]);
        $output = $commandTester->getDisplay();

        $I->assertEquals("Service returned message 'Not Found'\n", $output);


    }

    public function RepoNotFoundTest(AcceptanceTester $I)
    {
        $I->wantTo('Check for unknown repository given');

        /** @var \App\Kernel $kernel */
        $kernel = $I->getSymfonyKernel();
        $kernel->boot();
        $application = new Application($kernel);
        $command = $application->find('app:branch:checksum');
        $commandTester = new CommandTester($command);
        //app:branch:checksum php-fig/log master -s api.github.com
        $commandTester->execute([
            'repository' => 'php1-fig/log',
            'branch' => 'master',
            '--service' => 'api.github.com'
        ]);
        $output = $commandTester->getDisplay();

        $I->assertEquals("Service returned message 'Not Found'\n", $output);
    }

}
