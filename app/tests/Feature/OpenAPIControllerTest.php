<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class OpenAPIControllerTest extends WebTestCase
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
            '/oas'
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
    }
}