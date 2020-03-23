<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AgeRating
 *
 * @ORM\Table(name="age_rating")
 * @ORM\Entity
 */
class AgeRating
{
    /**
     * @var int
     *
     * @ORM\Column(name="age", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $age;

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
