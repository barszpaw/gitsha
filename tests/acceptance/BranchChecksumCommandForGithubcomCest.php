<?php

namespace App\Tests;


use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class BranchChecksumCommandForGithubcomCest
{

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
            '--service' => 'github.com',
        ]);
        $output = $commandTester->getDisplay();

        $I->assertEquals("Unknown branch 'master1'\n", $output);
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
        $commandTester->execute([
            'repository' => 'php1-fig/log',
            'branch' => 'master',
            '--service' => 'github.com',
        ]);
        $output = $commandTester->getDisplay();
        $I->assertContains("Service returned message 'fatal:", $output);
    }

    public function ExecIsSuccessfulTest(AcceptanceTester $I)
    {
        $I->wantTo('Check for Successful Exec');

        /** @var \App\Kernel $kernel */
        $kernel = $I->getSymfonyKernel();
        $kernel->boot();
        $application = new Application($kernel);
        $command = $application->find('app:branch:checksum');
        $commandTester = new CommandTester($command);
        //app:branch:checksum php-fig/log master -s api.github.com
        $commandTester->execute([
            'repository' => 'barszpaw/zadanie1',
            'branch' => 'master',
            '--service' => 'github.com',
        ]);
        $output = $commandTester->getDisplay();
        // sha is for repo those newer change so his checksum will never (almost) change.
        $I->assertEquals("5cae94da145e522ce748ca2aae90369e5a6ff5f6\n", $output);
    }

}
