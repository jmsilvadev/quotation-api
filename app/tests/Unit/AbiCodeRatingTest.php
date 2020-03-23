<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AbiCodeRatingTest extends WebTestCase
{
    /** @test */
    public function itHasRequiredProperties()
    {
        $this->assertClassHasAttribute('abiCode', 'App\Entity\AbiCodeRating');
        $this->assertClassHasAttribute('ratingFactor', 'App\Entity\AbiCodeRating');
    }
}