<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AgeRatingTest extends WebTestCase
{
    /** @test */
    public function itHasRequiredProperties()
    {
        $this->assertClassHasAttribute('age', 'App\Entity\AgeRating');
        $this->assertClassHasAttribute('ratingFactor', 'App\Entity\AgeRating');
    }
}