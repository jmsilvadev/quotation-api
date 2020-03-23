<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AbiCodeRating
 *
 * @ORM\Table(name="abi_code_rating")
 * @ORM\Entity
 */
class AbiCodeRating
{
    /**
     * @var string
     *
     * @ORM\Column(name="abi_code", type="string", length=10, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $abiCode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="rating_factor", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $ratingFactor;

    /**
     * Get the value of ratingFactor
     *
     * @return  string|null
     */
    public function getRatingFactor()
    {
        return $this->ratingFactor;
    }
}
