<?php


namespace App\BranchChecksum;

abstract class Service implements ServiceInterface
{
    /** @var string */
    protected $serviceName;
    /** @var string */
    protected $repositoryName;
    /** @var string */
    protected $branchName;

    /**
     * @param string $serviceName
     */
    public function setServiceName(string $serviceName): void
    {
        $this->serviceName = $serviceName;
    }


    /**
     * @param string $repositoryName
     */
    public function setRepository(string $repositoryName): void
    {
        $this->repositoryName = $repositoryName;
    }


    /**
     * @param string $branchName
     */
    public function setBranchName(string $branchName): void
    {
        $this->branchName = $branchName;
    }

    /**
     * @throws \App\BranchChecksum\Exception\UnknownBranchException
     */
    abstract public function getSha(): string;
}