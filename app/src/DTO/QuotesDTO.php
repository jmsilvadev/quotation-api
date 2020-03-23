<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class QuotesDTO
{

    /**
     * @Assert\NotNull
     * @Assert\Length(max = 20)
     * @var string
     */
    private $policyNumber;

    /**
     * @Assert\NotNull
     * @Assert\GreaterThan(0)
     * @var int
     */
    private $age;

    /**
     * @Assert\NotNull
     * @Assert\Length(max = 10)
     * @var string
     */
    private $postcode;

    /**
     * @Assert\NotNull
     * @var string
     */
    private $regNo;

    /**
     * @Assert\NotNull
     * @Assert\Length(max = 10)
     * @var string
     */
    private $abiCode;
    
    /**
     * @Assert\NotNull
     * @Assert\Length(max = 12)
     * @Assert\Type("numeric")
     * @var float
     */
    private $premium;

    public function __construct($age = null, $postcode = null, $regNo = null)
    {
        $this->age = $age;
        $this->postcode = $postcode;
        $this->regNo = $regNo;
    }
   

    /**
     * Get the value of policyNumber
     */
    public function getPolicyNumber()
    {
        return $this->policyNumber;
    }

    /**
     * Set the value of policyNumber
     *
     * @return  self
     */
    public function setPolicyNumber($policyNumber)
    {
        $this->policyNumber = $policyNumber;

        return $this;
    }

    /**
     * Get the value of age
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Get the value of postcode
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * Get the value of regNo
     */
    public function getRegNo()
    {
        return $this->regNo;
    }

    /**
     * Get the value of abiCode
     */
    public function getAbiCode()
    {
        return $this->abiCode;
    }

    /**
     * Set the value of abiCode
     *
     * @return  self
     */
    public function setAbiCode($abiCode)
    {
        $this->abiCode = $abiCode;

        return $this;
    }

    /**
     * Get the value of premium
     */
    public function getPremium()
    {
        return $this->premium;
    }

    /**
     * Set the value of premium
     *
     * @return  self
     */
    public function setPremium($premium)
    {
        $this->premium = $premium;

        return $this;
    }
}
