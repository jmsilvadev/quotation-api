<?php

namespace App\HttpClient;

use Exception;
use Symfony\Component\HttpClient\HttpClient;
use App\HttpClient\Interfaces\HttpClientInterface;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class BasicClient implements HttpClientInterface
{
    private string $method;
    private string $url;
    private bool $toArray = false;

    public function makeRequest(array $data = null)
    {
        
        $params = [];
        if ($data) {
            $type = ($this->method == 'GET') ? 'query' : 'body';
            $params = [
                $type => [ $data ],
            ];
        }

        try {
            $httpClient = HttpClient::create();
            $response = $httpClient->request($this->method, $this->url, $params);
        } catch (Exception $e) {
            return [
                'code' => 500,
                'response' => null,
            ];
        }
        
        return [
            'code' => $response->getStatusCode(),
            'response' => $this->toArray ? $response->getContent() :  $response->toArray(),
        ];
    }

    /**
     * Set the value of method
     *
     * @return  self
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }


    /**
     * Set the value of url
     *
     * @return  self
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Set the value of toArray
     *
     * @return  self
     */
    public function setToArray(bool $toArray)
    {
        $this->toArray = $toArray;
    }
}
