<?php


namespace App\BranchChecksum;


interface ServiceInterface
{
    function setServiceName(string $serviceName): void;

    function setRepository(string $repositoryName): void;

    function setBranchName(string $branchName): void;

    function getSha(): string;
}
