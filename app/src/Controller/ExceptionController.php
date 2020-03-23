<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpClient\Exception\TransportException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ExceptionController extends AbstractController
{
    private $errorMap = [
        Response::HTTP_BAD_REQUEST => 'Bad Request',
        Response::HTTP_UNAUTHORIZED => 'Unauthorized',
        Response::HTTP_FORBIDDEN => 'Forbidden',
        Response::HTTP_NOT_FOUND => 'The url requested not found',
        Response::HTTP_METHOD_NOT_ALLOWED => 'Method not allowed',
        Response::HTTP_NOT_ACCEPTABLE => 'This requestis not acceptable',
        Response::HTTP_REQUEST_TIMEOUT => 'Request timeout, please try again later',
        Response::HTTP_CONFLICT => 'There is a conflit with your request, please check the mandatory fields',
        Response::HTTP_PRECONDITION_FAILED => 'Precondiction failed',
        Response::HTTP_LOCKED => 'Loced',
    ];

    public function showAction(FlattenException $exception)
    {
        $statusCode = $exception->getStatusCode();
        if ($exception->getClass() === TransportException::class) {
            $statusCode = Response::HTTP_FAILED_DEPENDENCY;
        }
        
        return new JsonResponse(
            [
                'code' => $statusCode,
                'description' => $this->getError($exception),
            ],
            $exception->getStatusCode(),
            [
                'Content-Type' => 'application/json; charset=UTF-8'
            ]
        );
    }

    public function getError(FlattenException $exception): string
    {
        $statusCode = $exception->getStatusCode();
        if ($exception->getClass() === TransportException::class) {
            return 'The third party API is Unavailable. Please try again later or contact the support.';
        }

        if ($statusCode === 500) {
            return sprintf(
                '%s in file %s and line %d',
                $exception->getMessage(),
                $exception->getFile(),
                $exception->getLine()
            );
        }
        $error = (array_key_exists($statusCode, $this->errorMap)) ? $this->errorMap[$statusCode] : 'Unknow error';
        return $error;
    }
}
