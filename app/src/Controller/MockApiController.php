<?php

namespace App\Controller;

use App\Responses\RestJsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/mockapi/{regNo}", name="mockup", methods={"GET"})
 */
class MockApiController extends AbstractController
{
    public function __invoke(string $regNo): RestJsonResponse
    {
        $abiCodes = [];
        $abiCodes['regno-1'] = "22529902";
        $abiCodes['regno-2'] = "46545255";
        $abiCodes['regno-3'] = "52123803";
        for ($i = 3; $i < 500; $i++) {
            $abiCodes['regno-' . $i] = 'abiCode' . $i;
        }
        $response = isset($abiCodes[$regNo]) ? $abiCodes[$regNo] : 'Not Found';

        return new RestJsonResponse(
            [
                $response
            ],
            Response::HTTP_OK
        );
    }
}
