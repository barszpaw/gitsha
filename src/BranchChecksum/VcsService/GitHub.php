<?php


namespace App\BranchChecksum\VcsService;


use App\BranchChecksum\Exception\NotFoundException;
use App\BranchChecksum\Exception\UnknownBranchException;
use App\BranchChecksum\Service;
use App\BranchChecksum\ServiceInterface;
use App\BranchChecksum\VcsServices;
use Symfony\Component\Process\Process;

class GitHub extends Service
{
    /** @var string */
    protected $serviceName;

    /**
     * GitHub constructor.
     */
    public function __construct()
    {
        $this->serviceName = VcsServices::GITHUB_COM;
    }

    /**
     * @return string
     * @throws \App\BranchChecksum\Exception\UnknownBranchException
     */
    function getSha(): string
    {
        $process = new Process([
            'git',
            'ls-remote',
            'https://'.$this->serviceName.'/'.$this->repositoryName,
            $this->branchName,
        ]);
        $process->run();
        $output = $process->getOutput();
        if (!$process->isSuccessful()) {
            throw new NotFoundException($process->getErrorOutput());
        }
        if (empty($output)) {
            throw new UnknownBranchException();
        }
        $output = preg_split('/\s+/', $output);

        return $output[0];
    }
}
