<?php

namespace App\Controller;

use App\Entity\Quote;
use App\Responses\RestJsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/quotes/{id}", name="getquotes", methods={"GET"})
 */
class GetQuotesController extends AbstractController
{
    public function __invoke(int $id): Response
    {
        $repository = $this->getDoctrine()->getRepository(Quote::class);
        
        $quote = $repository->find($id);
        $response = [];
        if ($quote) {
            $response = [
                'id' => $quote->getId(),
                'policyNumber' => $quote->getPolicyNumber(),
                'age' => $quote->getAge(),
                'postcode' => $quote->getPostcode(),
                'regNo' => $quote->getRegNo(),
                'abiCode' => $quote->getAbiCode(),
                'premium' => number_format($quote->getPremium(), 2),
            ];
        }

        return new RestJsonResponse(
            $response,
            Response::HTTP_CREATED
        );
    }
}
