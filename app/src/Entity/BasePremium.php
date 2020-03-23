<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BasePremium
 *
 * @ORM\Table(name="base_premium")
 * @ORM\Entity
 */
class BasePremium
{
    /**
     * @var string
     *
     * @ORM\Column(name="base_premium", type="decimal", precision=10, scale=2, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $basePremium;



    /**
     * Get the value of basePremium
     *
     * @return  string
     */
    public function getBasePremium()
    {
        return $this->basePremium;
    }
}
