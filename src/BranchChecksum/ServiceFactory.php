<?php


namespace App\BranchChecksum;


use App\BranchChecksum\Exception\UnknownServiceException;
use App\BranchChecksum\Product\BitBucket;
use App\BranchChecksum\Product\GitHub;

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
            case 'bitbucket.com':
                $service = new BitBucket();
                $service->setBranchName($branchName);
                $service->setRepository($repositoryName);
                break;
            default:
                throw new UnknownServiceException();
        }
        return $service;
    }
}