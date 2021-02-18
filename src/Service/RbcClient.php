<?php


namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class RbcClient
{
    const URL = 'http://rbc.ru/';

    /** @var HttpClientInterface */
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getLastNews(): string
    {
        return $this->httpClient->request('GET', self::URL)->getContent();
    }

    public function getNews(string $url): string
    {
        return $this->httpClient->request('GET', $url)->getContent();
    }
}
