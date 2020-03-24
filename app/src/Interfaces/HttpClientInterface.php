<?php

namespace App\Interfaces;

interface HttpClientInterface
{
    public function makeRequest(array $body = null);
    public function setMethod($method);
    public function setUrl($url);
    public function setToArray(bool $flag);
}
