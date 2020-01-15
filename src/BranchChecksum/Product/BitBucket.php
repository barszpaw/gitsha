<?php


namespace App\BranchChecksum\Product;


use App\BranchChecksum\Exception\UnknownServiceException;
use App\BranchChecksum\Service;


class BitBucket extends Service
{
    /** @var string */
    protected $serviceName;

    public function __construct()
    {
        $this->serviceName = 'bitbucket.com';
    }


    function getSha(): string
    {
        throw new UnknownServiceException();
    }
}