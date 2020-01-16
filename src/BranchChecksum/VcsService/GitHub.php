<?php


namespace App\BranchChecksum\VcsService;


use App\BranchChecksum\Exception\UnknownBranchException;
use App\BranchChecksum\Service;
use App\BranchChecksum\ServiceInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class GitHub extends Service implements ServiceInterface
{
    /** @var string */
    protected $serviceName;

    /**
     * GitHub constructor.
     */
    public function __construct()
    {
        $this->serviceName = 'github.com';
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
            'https://' . $this->serviceName . '/' . $this->repositoryName,
            $this->branchName
        ]);
        $process->run();
        $output = $process->getOutput();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        if (empty($output)) {
            throw new UnknownBranchException();
        }
        $output = preg_split('/\s+/', $output);
        return $output[0];
    }
}