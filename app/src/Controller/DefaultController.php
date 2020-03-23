<?php

namespace App\Controller;

use App\Responses\RestJsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/", name="health", methods={"GET"})
 */
class DefaultController extends AbstractController
{
    public function __invoke(): RestJsonResponse
    {
        return new RestJsonResponse(
            [
                'status' => 'pass',
                'description' => 'Quotation System'
            ],
            Response::HTTP_CREATED
        );
    }
}
