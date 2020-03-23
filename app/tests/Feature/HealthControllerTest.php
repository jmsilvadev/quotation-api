<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class HealthControllerTest extends WebTestCase
{
    public $client;

    public function setUp()
    {
        $this->client = $this->createClient();
    }

    /** @test */
    public function itCheckHealthAndReturnsHttpResponse()
    {
        $this->client->request(
            'GET',
            '/'
        );

        $this->assertEquals(
            Response::HTTP_CREATED,
            $this->client->getResponse()
                ->getStatusCode()
        );

        $this->assertEquals(
            $this->client->getResponse()
                ->headers
                ->get('Content-Type'),
            'application/json; charset=UTF-8'
        );
    }

    /** @test */
    public function itCheckHealthAndReturnsHttpResponseNotAllowed()
    {
        $this->client->request(
            'POST',
            '/'
        );

        $this->assertEquals(
            Response::HTTP_METHOD_NOT_ALLOWED,
            $this->client->getResponse()
                ->getStatusCode()
        );
        
        $this->assertEquals(
            $this->client->getResponse()
                ->headers
                ->get('Content-Type'),
            'application/json; charset=UTF-8'
        );
    }

    /** @test */
    public function itGetUnexistentEndpointAndReturnsHttpResponseNotFound()
    {
        $this->client->request(
            'GET',
            '/ghost'
        );

        $this->assertEquals(
            Response::HTTP_NOT_FOUND,
            $this->client->getResponse()
                ->getStatusCode()
        );
        
        $this->assertEquals(
            $this->client->getResponse()
                ->headers
                ->get('Content-Type'),
            'application/json; charset=UTF-8'
        );
    }
}