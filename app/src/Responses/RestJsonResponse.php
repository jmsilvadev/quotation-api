<?php

namespace App\Responses;

use App\Interfaces\RestResponseInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class RestJsonResponse extends JsonResponse implements RestResponseInterface
{
    public function __construct(array $data, int $statusCode = null)
    {
        $statusCode = $statusCode ?? Response::HTTP_CREATED;
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
