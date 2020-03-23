<?php

namespace App\Responses;

use App\Responses\Interfaces\RestResponseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class RestJsonResponse extends JsonResponse implements RestResponseInterface
{
    public function __construct(array $data, int $statusCode)
    {
        parent::__construct(
            [
                'data' => $data
            ],
            $statusCode,
            [
                'Content-Type' => 'application/json; charset=UTF-8'
            ]
        );
    }
}
