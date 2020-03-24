<?php

namespace App\Interfaces;

interface QuotationServiceInterface
{
    public function setAbiCodePremium(): void;
    public function setAgePremium(): void;
    public function setPostcodePremium(): void;
    public function getAbiCode(string $regNo): string;
    public function getQuotation();
}
