<?php


namespace App\BranchChecksum;


use App\BranchChecksum\Exception\UnknownServiceException;
use App\BranchChecksum\VcsService\ApiGitHub;
use App\BranchChecksum\VcsService\GitHub;

class ServiceFactory
{


    public function create(string $serviceName): Service
    {
        $service = null;
        switch ($serviceName) {
            case VcsServices::GITHUB_COM:
                $service = new GitHub();
                break;
            case VcsServices::API_GITHUB_COM:
                $service = new ApiGitHub();
                break;
            default:

                throw new UnknownServiceException();
        }

        return $service;
    }
}