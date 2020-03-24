<?php

namespace App\Services;

use App\DTO\QuotesDTO;
use App\Interfaces\QuotationServiceInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class QuotationService implements QuotationServiceInterface
{
    private $quote;
    private $container;
    private $repository;
    private $valuePremium = 0;

    public function __construct(ContainerBuilder $container, QuotesDTO $quote)
    {
        $this->container = $container;
        $this->quote = $quote;
    }

    private function setInitialBasePremiumValue(): void
    {
        $basePremium = $this->container->get('BasePremium');
        $basePremiumValues = $basePremium->findOneBy([]);
        $this->valuePremium = $basePremiumValues
            ? $basePremiumValues->getBasePremium()
            : 0;
    }

    public function setAbiCodePremium(): void
    {
        $this->repository = $this->container->get('AbiCodeRating');
        $ratingValue = $this->repository->createQueryBuilder('t')
               ->where('t.abiCode LIKE :abiCode')
               ->setParameter('abiCode', $this->quote->getAbiCode() . '%')
               ->getQuery()
               ->getResult();
        $value = $ratingValue ? $ratingValue[0]->getRatingFactor() : 1;
        $this->valuePremium = $value * $this->valuePremium;
    }

    public function setAgePremium(): void
    {
        $this->repository = $this->container->get('AgeRating');
        $ratingValue = $this->repository->find($this->quote->getAge());
        $value = $ratingValue ? $ratingValue->getRatingFactor() : 1;
        $this->valuePremium = $value * $this->valuePremium;
    }

    public function setPostcodePremium(): void
    {
        $this->repository = $this->container->get('PostcodeRating');
        $ratingValue = $this->repository->createQueryBuilder('t')
               ->where('t.postcodeArea LIKE :postcodeArea')
               ->setParameter('postcodeArea', $this->quote->getPostcode() . '%')
               ->getQuery()
               ->getResult();
        $value = $ratingValue ? $ratingValue[0]->getRatingFactor() : 1;
        $this->valuePremium = $value * $this->valuePremium;
    }

    public function getAbiCode(string $regNo): string
    {
        $serviceVehicle = new VehicleRegistrationService();
        return $serviceVehicle->getAbiCode($regNo);
    }

    public function getQuotation(): QuotesDTO
    {
        if (!$this->quote->getRegNo()) {
            return $this->quote;
        }

        $abiCode = $this->getAbiCode($this->quote->getRegNo());
        if ($abiCode === 'Not Found') {
            return $this->quote;
        }
        
        $this->setInitialBasePremiumValue();
        $this->quote->setAbiCode($abiCode);
        $this->setAbiCodePremium();
        $this->setAgePremium();
        $this->setPostcodePremium();
        $this->quote->setPremium($this->valuePremium);

        return $this->quote;
    }
}
