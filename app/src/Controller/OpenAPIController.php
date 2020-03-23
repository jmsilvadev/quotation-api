<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/oas", name="oas", methods={"GET"})
 */
class OpenAPIController extends AbstractController
{
    public function __invoke()
    {
        $applicationSpecifics = file_get_contents(__DIR__ . '/../../public/openapi.json');
        return new JsonResponse(
            $applicationSpecifics,
            Response::HTTP_OK,
            [
                'Content-Type' => 'application/json; charset=UTF-8'
            ],
            true
        );
    }
}
