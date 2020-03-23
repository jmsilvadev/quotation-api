<?php

namespace App\Tests;

use App\HttpClient\BasicClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpClient\Exception\TransportException;

class BaseClientTest extends WebTestCase
{

    public $httpClient;

    public function setUp()
    {
        $this->httpClient =new BasicClient();
    }

    /** @test */
    public function itHasValidGet()
    {
        $this->httpClient->setMethod('GET');
        $this->httpClient->setUrl('http://127.0.0.1:8080/mockapi/regno-1');
        $this->httpClient->setToArray(false);
        $response = $this->httpClient->makeRequest();
        $this->assertEquals($response['code'], Response::HTTP_OK);
    }

    /** @test */
    public function itHasValidGetWithBody()
    {
        $this->httpClient->setMethod('GET');
        $this->httpClient->setUrl('http://127.0.0.1:8080/mockapi/regno-1');
        $this->httpClient->setToArray(false);
        $response = $this->httpClient->makeRequest(['teste']);
        $this->assertEquals($response['code'], Response::HTTP_OK);
    }

    /** @test */
    public function itHasInValidGetUrl()
    {

        $this->httpClient->setMethod('GET');
        $this->httpClient->setUrl('http://127.0.0.1/mockapi/regno-1');
        try {
            $this->httpClient->makeRequest(['teste']);
        } catch(\Exception $e) {
            $this->assertInstanceOf(TransportException::class, $e);
        }
    }
}