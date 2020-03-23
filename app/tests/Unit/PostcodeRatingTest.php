<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostcodeRatingTest extends WebTestCase
{
    /** @test */
    public function itHasRequiredProperties()
    {
        $this->assertClassHasAttribute('postcodeArea', 'App\Entity\PostcodeRating');
        $this->assertClassHasAttribute('ratingFactor', 'App\Entity\PostcodeRating');
    }
}