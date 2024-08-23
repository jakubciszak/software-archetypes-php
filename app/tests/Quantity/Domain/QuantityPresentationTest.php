<?php

namespace Quantity\Domain;
use PHPUnit\Framework\TestCase;
use SoftwareArchetypesPhp\TestsQuantityFixtures\MetricFixtureFactory;
use SoftwareArchetypesPhp\TestsQuantityFixtures\QuantityFixtureFactory;
use SoftwareArchetypesPhp\TestsQuantityFixtures\RoundingPolicyFixtureFactory;

class QuantityPresentationTest extends TestCase
{
    public function testPresentationWithPointer(): void
    {
        $quantity = QuantityFixtureFactory::get(
            number: 10,
            roundingPolicy: RoundingPolicyFixtureFactory::get(),
            metric: MetricFixtureFactory::get('meter', 'm', ));
        $this->assertEquals(10.00, $quantity->value());
        $this->assertEquals('m', $quantity->symbol());
    }

    public function testPresentationInt(): void
    {
        $quantity = QuantityFixtureFactory::get(
            number: 10.5653,
            roundingPolicy: RoundingPolicyFixtureFactory::get(numberOfDigits: 0),
            metric: MetricFixtureFactory::get('meter', 'm', ));
        $this->assertEquals(11.00, $quantity->value());
        $this->assertEquals('m', $quantity->symbol());
    }
}