<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class PostQuotesControllerTest extends WebTestCase
{
    public $client;

    public function setUp()
    {
        $this->client = $this->createClient();
    }

    /** @test */
    public function itPostAValidQuoteAndReturnsHttpResponse()
    {
        $body = [
            'age' => 17,
            'postcode' => 'PE3',
            'regNo' => 'regno-1',
            'policyNumber' => 'policy-123',
        ];

        $this->client->request(
            'POST',
            '/quotes',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($body)
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

        $quote = json_decode($this->client->getResponse()->getContent());

        $this->assertObjectHasAttribute('id', $quote->data);
        $this->assertObjectHasAttribute('policyNumber', $quote->data);
        $this->assertObjectHasAttribute('age', $quote->data);
        $this->assertObjectHasAttribute('postcode', $quote->data);
        $this->assertObjectHasAttribute('regNo', $quote->data);
        $this->assertObjectHasAttribute('abiCode', $quote->data);
        $this->assertObjectHasAttribute('premium', $quote->data);

        $this->assertEquals($body['age'], $quote->data->age);
        $this->assertEquals($body['postcode'], $quote->data->postcode);
        $this->assertEquals($body['regNo'], $quote->data->regNo);
    }

    /** @test */
    public function itPostAnInvalidQuoteWihtouRegNoAndReturnsHttpResponse()
    {
        $body = [
            'age' => 17,
            'postcode' => 'PE3',
            'policyNumber' => 'policy-123',
        ];

        $this->client->request(
            'POST',
            '/quotes',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($body)
        );

        $this->assertEquals(
            Response::HTTP_CONFLICT,
            $this->client->getResponse()
                ->getStatusCode()
        );

        $this->assertEquals(
            $this->client->getResponse()
                ->headers
                ->get('Content-Type'),
            'application/json; charset=UTF-8'
        );

        $quote = json_decode($this->client->getResponse()->getContent());
        $this->assertObjectHasAttribute('regNo', $quote->description);
        $this->assertEquals('This value should not be null.', $quote->description->regNo[0]);
    }

    /** @test */
    public function itPostAnInexistentRegNoAndReturnsHttpResponse()
    {
        $body = [
            'age' => 17,
            'postcode' => 'PE3',
            'regNo' => 'nonexistent-1',
            'policyNumber' => 'policy-123',
        ];

        $this->client->request(
            'POST',
            '/quotes',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($body)
        );

        $this->assertEquals(
            Response::HTTP_CONFLICT,
            $this->client->getResponse()
                ->getStatusCode()
        );

        $this->assertEquals(
            $this->client->getResponse()
                ->headers
                ->get('Content-Type'),
            'application/json; charset=UTF-8'
        );

        $quote = json_decode($this->client->getResponse()->getContent());
        $this->assertObjectHasAttribute('abiCode', $quote->description);
        $this->assertEquals('This value should not be null.', $quote->description->abiCode[0]);
    }


    /** @test */
    public function itGetAndReturnsHttpResponseNotAllowed()
    {
        $this->client->request(
            'GET',
            '/quotes'
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
}