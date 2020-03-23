<?php

namespace App\Responses\Interfaces;

interface RestResponseInterface
{
    public function __construct(array $data, int $statusCode);
}
