<?php

namespace App\Services;

use App\HttpClient\BasicClient;
use Symfony\Component\HttpFoundation\Response;
use App\HttpClient\Interfaces\HttpClientInterface;

class VehicleRegistrationService
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient = null)
    {
        $this->httpClient = $httpClient ?? new BasicClient();
    }

    public function getAbiCode(string $regNo): string
    {
        $this->httpClient->setMethod('GET');
        $this->httpClient->setUrl('http://127.0.0.1:8080/mockapi/' . $regNo);
        $this->httpClient->setToArray(false);
        
        $response = $this->httpClient->makeRequest();
        
        $abiCode = '';
        if ($response['code'] == Response::HTTP_OK) {
            $abiCode = $response['response'][0];
        }
        return $abiCode;
    }
}
