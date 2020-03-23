<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BasePremiumTest extends WebTestCase
{
    /** @test */
    public function itHasRequiredProperties()
    {
        $this->assertClassHasAttribute('basePremium', 'App\Entity\BasePremium');
    }
}