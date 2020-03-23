<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PostcodeRating
 *
 * @ORM\Table(name="postcode_rating")
 * @ORM\Entity
 */
class PostcodeRating
{
    /**
     * @var string
     *
     * @ORM\Column(name="postcode_area", type="string", length=4, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $postcodeArea;

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
