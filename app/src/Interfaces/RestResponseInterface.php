<?php

namespace App\Interfaces;

interface RestResponseInterface
{
    public function __construct(array $data, int $statusCode = null);
}
