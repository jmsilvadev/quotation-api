<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class QuoteTest extends WebTestCase
{
    /** @test */
    public function itHasRequiredProperties()
    {
        $this->assertClassHasAttribute('id', 'App\Entity\Quote');
        $this->assertClassHasAttribute('policyNumber', 'App\Entity\Quote');
        $this->assertClassHasAttribute('age', 'App\Entity\Quote');
        $this->assertClassHasAttribute('postcode', 'App\Entity\Quote');
        $this->assertClassHasAttribute('regNo', 'App\Entity\Quote');
        $this->assertClassHasAttribute('abiCode', 'App\Entity\Quote');
        $this->assertClassHasAttribute('premium', 'App\Entity\Quote');
    }
}