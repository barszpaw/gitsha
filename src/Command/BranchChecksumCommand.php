<?php

namespace App\Command;

use App\BranchChecksum\Exception\NotFoundException;
use App\BranchChecksum\Exception\UnknownBranchException;
use App\BranchChecksum\Exception\UnknownServiceException;
use App\BranchChecksum\ServiceFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class BranchChecksumCommand extends Command
{
    protected const DEFAULT_SERVICENAME = 'github.com';
    protected static $defaultName = 'app:branch:checksum';

    protected function configure()
    {
        $this->setDescription('Show Checksum of branch for given repo from remote git server (default: github) ')->setHelp('This command allows you to get sha on given branch in remote git repo.'."\n"."Available remote service is: github.com, api.github.com")->addArgument('repository',
            InputArgument::REQUIRED, 'Repository name eg.: php-fig/log')->addArgument('branch', InputArgument::REQUIRED,
            'Branch name eg.: master')->addOption('service', 's', InputOption::VALUE_OPTIONAL, 'Service name.',
            self::DEFAULT_SERVICENAME);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $repository = $input->getArgument('repository');
        $branch = $input->getArgument('branch');
        $serviceName = $input->getOption('service');

        try {
            if ($repository && $branch && $serviceName) {
                $factory = new ServiceFactory();
                $service = $factory->create($serviceName);
                $service->setRepository($repository);
                $service->setBranchName($branch);
                $service->setServiceName($serviceName);
                $sha = $service->getSha();
                $output->writeln($sha);
            }
        } catch (UnknownServiceException $e) {
            $output->writeln("Unknown service <fg=red>'{$serviceName}'</>");

            return 1;
        } catch (UnknownBranchException $e) {
            $output->writeln("Unknown branch <fg=red>'{$branch}'</>");

            return 1;
        } catch (NotFoundException $e) {
            $output->writeln("Service returned message <fg=red>'{$e->getMessage()}'</>");

            return 1;
        }

        return 0;
    }
}
