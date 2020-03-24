<?php

namespace App\Controller;

use App\Responses\RestJsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/oas", name="oas", methods={"GET"})
 */
class OpenAPIController extends AbstractController
{
    public function __invoke()
    {
        $applicationSpecifics = file_get_contents(__DIR__ . '/../../public/openapi.json');
        return new RestJsonResponse(
            json_decode($applicationSpecifics, true),
            Response::HTTP_OK
        );
    }
}
