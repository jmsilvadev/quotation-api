<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class MockApiControllerTest extends WebTestCase
{
    public $client;

    public function setUp()
    {
        $this->client = $this->createClient();
    }

    /** @test */
    public function itGetsARequestInAPIAndReturnsHttpResponseOK()
    {
        $this->client->request(
            'GET',
            '/mockapi/regno-1'
        );

        $this->assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()
                ->getStatusCode()
        );

        $this->assertEquals(
            $this->client->getResponse()
                ->headers
                ->get('Content-Type'),
            'application/json; charset=UTF-8'
        );
        
        $mock = json_decode($this->client->getResponse()->getContent());
        $this->assertEquals('22529902', $mock[0]);
    }
    

    /** @test */
    public function itGetsARequestInAPIAndReturnsHttpResponseNotFound()
    {
        $this->client->request(
            'GET',
            '/mockapi/notfound-1'
        );

        $this->assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()
                ->getStatusCode()
        );

        $this->assertEquals(
            $this->client->getResponse()
                ->headers
                ->get('Content-Type'),
            'application/json; charset=UTF-8'
        );
        
        $mock = json_decode($this->client->getResponse()->getContent());
        $this->assertEquals('Not Found', $mock[0]);
    }
}