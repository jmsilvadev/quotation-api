<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Quote
 *
 * @ORM\Table(name="quote")
 * @ORM\Entity(repositoryClass="App\Repository\QuoteRepository")
 */
class Quote
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="policy_number", type="string", length=20, nullable=false)
     * @Assert\NotNull
     * @Assert\Length(max = 20)
     */
    private $policyNumber;

    /**
     * @var int|null
     *
     * @ORM\Column(name="age", type="integer", nullable=true)
     */
    private $age;

    /**
     * @var string|null
     *
     * @ORM\Column(name="postcode", type="string", length=10, nullable=true)
     */
    private $postcode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="reg_no", type="string", length=10, nullable=true)
     * @Assert\Length(max = 10)
     */
    private $regNo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="abi_code", type="string", length=10, nullable=true)
     * @Assert\Length(max = 10)
     */
    private $abiCode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="premium", type="decimal", precision=10, scale=2, nullable=true)
     * @Assert\Length(max = 10)
     */
    private $premium;



    /**
     * Get the value of id
     *
     * @return  int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of policyNumber
     *
     * @return  string
     */
    public function getPolicyNumber()
    {
        return $this->policyNumber;
    }

    /**
     * Set the value of policyNumber
     *
     * @param  string  $policyNumber
     *
     * @return  self
     */
    public function setPolicyNumber(string $policyNumber)
    {
        $this->policyNumber = $policyNumber;

        return $this;
    }

    /**
     * Get the value of regNo
     *
     * @return  string|null
     */
    public function getRegNo()
    {
        return $this->regNo;
    }

    /**
     * Set the value of regNo
     *
     * @param  string|null  $regNo
     *
     * @return  self
     */
    public function setRegNo($regNo)
    {
        $this->regNo = $regNo;

        return $this;
    }

    /**
     * Get the value of abiCode
     *
     * @return  string|null
     */
    public function getAbiCode()
    {
        return $this->abiCode;
    }

    /**
     * Set the value of abiCode
     *
     * @param  string|null  $abiCode
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
     *
     * @return  string|null
     */
    public function getPremium()
    {
        return $this->premium;
    }

    /**
     * Set the value of premium
     *
     * @param  string|null  $premium
     *
     * @return  self
     */
    public function setPremium($premium)
    {
        $this->premium = $premium;

        return $this;
    }

    /**
     * Get the value of age
     *
     * @return  int|null
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set the value of age
     *
     * @param  int|null  $age
     *
     * @return  self
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get the value of postcode
     *
     * @return  string|null
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * Set the value of postcode
     *
     * @param  string|null  $postcode
     *
     * @return  self
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;

        return $this;
    }
}
