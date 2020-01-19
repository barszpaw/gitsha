<?php


namespace App\BranchChecksum\VcsService;

use App\BranchChecksum\Exception\NotFoundException;
use App\BranchChecksum\Service;
use App\BranchChecksum\VcsServices;
use Symfony\Component\HttpClient\HttpClient;


class ApiGitHub extends Service
{
    /** @var string */
    protected $serviceName;

    /**
     * ApiGitHub constructor.
     */
    public function __construct()
    {
        $this->serviceName = VcsServices::API_GITHUB_COM;
    }

    /**
     * @return string
     * @throws \App\BranchChecksum\Exception\NotFoundException
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    function getSha(): string
    {
        $client = HttpClient::create();
        $response = $client->request('GET',
            'https://'.$this->serviceName.'/repos/'.$this->repositoryName.'/git/refs/heads/'.$this->branchName);

        $statusCode = $response->getStatusCode();
        $content = (object)$response->toArray(false);

        if ($statusCode != 200) {
            throw new NotFoundException($content->message);
        } else {
            $content = $content->object['sha'];
        }

        return $content;
    }
}