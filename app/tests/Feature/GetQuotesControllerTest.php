<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class GetQuotesControllerTest extends WebTestCase
{
    public $client;
    public $id;

    public function setUp()
    {
        $this->client = $this->createClient();
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

        $quote = json_decode($this->client->getResponse()->getContent());

        $this->id = $quote->data->id;
    }
    
    /** @test */
    public function itGetsAQuoteAndReturnsHttpResponse()
    {
        $this->client->request(
            'GET',
            '/quotes/' . $this->id
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
    }
    

    /** @test */
    public function itPostAndReturnsHttpResponseNotAllowed()
    {
        $this->client->request(
            'POST',
            '/quotes/' . $this->id
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
    public function itGetUnexistentIdAndReturnsAnEmptyArray()
    {
        $this->client->request(
            'GET',
            '/quotes/1121212'
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
        $this->assertEquals([], $quote->data);
    }
}