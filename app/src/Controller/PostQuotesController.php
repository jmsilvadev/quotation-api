<?php

namespace App\Controller;

use App\Entity\Quote;
use App\DTO\QuotesDTO;
use App\Entity\AgeRating;
use App\Entity\BasePremium;
use App\Entity\AbiCodeRating;
use App\Entity\PostcodeRating;
use App\Services\QuotationService;
use App\Responses\RestJsonResponse;
use App\Exceptions\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/quotes", name="postquotes", methods={"POST"})
 * @ParamConverter("quotesDTO", class="\App\DTO\QuotesDTO")
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class PostQuotesController extends AbstractController
{
    public function __invoke(QuotesDTO $quotesDTO, ValidatorInterface $validator): Response
    {
        //DIC to inject repositories in in the service
        $containerBuilder = new ContainerBuilder();
        $repositoryAbiCode = $this->getDoctrine()->getRepository(AbiCodeRating::class);
        $repositoryAgeRating = $this->getDoctrine()->getRepository(AgeRating::class);
        $repositoryPostcodeRating = $this->getDoctrine()->getRepository(PostcodeRating::class);
        $repositoryBasePremium = $this->getDoctrine()->getRepository(BasePremium::class);
        $containerBuilder->set('AbiCodeRating', $repositoryAbiCode);
        $containerBuilder->set('AgeRating', $repositoryAgeRating);
        $containerBuilder->set('PostcodeRating', $repositoryPostcodeRating);
        $containerBuilder->set('BasePremium', $repositoryBasePremium);

        //Service to generate a quotation and persist in DTO
        $quoteService = new QuotationService($containerBuilder, $quotesDTO);
        $quotesDTO = $quoteService->getQuotation();

        //Validations in the DTO
        $validator = $validator;
        $errors = $validator->validate($quotesDTO);
        if (count($errors) > 0) {
            $validations = new ValidationException($errors);
            return new JsonResponse(
                [
                    'code' => Response::HTTP_CONFLICT,
                    'description' => $validations->getMessages(),
                ],
                Response::HTTP_CONFLICT,
                [
                    'Content-Type' => 'application/json; charset=UTF-8'
                ]
            );
        }

        //Save data
        $entityManager = $this->getDoctrine()->getManager();
        $quote = new Quote();
        $quote->setPolicyNumber($quotesDTO->getPolicyNumber());
        $quote->setAge($quotesDTO->getAge());
        $quote->setPostcode($quotesDTO->getPostcode());
        $quote->setRegNo($quotesDTO->getRegNo());
        $quote->setAbiCode($quotesDTO->getAbiCode());
        $quote->setPremium($quotesDTO->getPremium());
        $entityManager->persist($quote);
        $entityManager->flush();

        return new RestJsonResponse(
            [
                'id' => $quote->getId(),
                'policyNumber' => $quote->getPolicyNumber(),
                'age' => $quote->getAge(),
                'postcode' => $quote->getPostcode(),
                'regNo' => $quote->getRegNo(),
                'abiCode' => $quote->getAbiCode(),
                'premium' => number_format($quote->getPremium(), 2),
            ],
            Response::HTTP_CREATED
        );
    }
}
