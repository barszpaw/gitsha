<?php


namespace App\BranchChecksum;


use App\BranchChecksum\Exception\UnimplementedException;
use RuntimeException;

class Service implements ServiceInterface
{
    /** @var string */
    protected $serviceName;
    /** @var string */
    protected $repositoryName;
    /** @var string */
    protected $branchName;

    /**
     * Service constructor.
     *
     * @param string $serviceName
     */
    public function __construct(string $serviceName = '')
    {
        $this->serviceName = $serviceName;
    }

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


    function getSha(): string
    {
        throw new UnimplementedException('Metod getSha not implement for "' . $this->serviceName . '"');
    }

}