<?php


namespace App\BranchChecksum;


use App\BranchChecksum\Exception\UnknownServiceException;
use App\BranchChecksum\VcsService\ApiGitHub;
use App\BranchChecksum\VcsService\GitHub;

class ServiceFactory
{
    public function create(string $branchName, string $repositoryName, string $serviceName): Service
    {
        $service = null;
        switch ($serviceName) {
            case 'github.com':
                $service = new GitHub();
                $service->setBranchName($branchName);
                $service->setRepository($repositoryName);
                break;
            case 'api.github.com':
                $service = new ApiGitHub();
                $service->setBranchName($branchName);
                $service->setRepository($repositoryName);
                break;

            default:
                throw new UnknownServiceException();
        }
        return $service;
    }
}