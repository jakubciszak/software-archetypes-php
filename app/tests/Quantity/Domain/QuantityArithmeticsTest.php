<?php

namespace Quantity\Domain;

use PHPUnit\Framework\TestCase;
use SoftwareArchetypesPhp\TestsQuantityFixtures\MetricFixtureFactory;
use SoftwareArchetypesPhp\TestsQuantityFixtures\QuantityFixtureFactory;

class QuantityArithmeticsTest extends TestCase
{
    public function testAdd(): void
    {
        $quantity = QuantityFixtureFactory::get(10);
        $quantityToAdd = QuantityFixtureFactory::get(5);

        $result = $quantity->add($quantityToAdd);

        $this->assertEquals(15, $result->amount);
    }

    public function testSubtract(): void
    {
        $quantity = QuantityFixtureFactory::get(10);
        $quantityToSubtract = QuantityFixtureFactory::get(5);

        $result = $quantity->subtract($quantityToSubtract);

        $this->assertEquals(5, $result->amount);
    }

    public function testMultiply(): void
    {
        $quantity = QuantityFixtureFactory::get(10);
        $multiplier = 5;

        $result = $quantity->multiply($multiplier);

        $this->assertEquals(50, $result->amount);

        $multiplier = QuantityFixtureFactory::get(5);

        $result = $quantity->multiply($multiplier);

        $this->assertEquals(50, $result->amount);

        $newQuantity = QuantityFixtureFactory::get(number: 5, metric: MetricFixtureFactory::get('meter', 'm', ''));

        $this->expectException(\InvalidArgumentException::class);
        $quantity->multiply($newQuantity);
    }

    public function testDivide(): void
    {
        $quantity = QuantityFixtureFactory::get(10);
        $divisor = 5;

        $result = $quantity->divide($divisor);

        $this->assertEquals(2, $result->amount);

        $divisor = QuantityFixtureFactory::get(5);

        $result = $quantity->divide($divisor);

        $this->assertEquals(2, $result->amount);

        $newQuantity = QuantityFixtureFactory::get(number: 5, metric: MetricFixtureFactory::get('meter', 'm', ''));

        $this->expectException(\InvalidArgumentException::class);
        $quantity->divide($newQuantity);
    }

    public function testDivisionByZero(): void
    {
        $quantity = QuantityFixtureFactory::get(10);
        $divisor = 0;

        $this->expectException(\DivisionByZeroError::class);
        $quantity->divide($divisor);

    }

    public function testIsGreaterThan(): void
    {
        $quantity = QuantityFixtureFactory::get(10);
        $quantityToCompare = QuantityFixtureFactory::get(5);

        $result = $quantity->isGreaterThan($quantityToCompare);

        $this->assertTrue($result);

        $quantity = QuantityFixtureFactory::get(10);
        $quantityToCompare = QuantityFixtureFactory::get(number: 5, metric: MetricFixtureFactory::get('meter', 'm', ''));
        $this->expectException(\InvalidArgumentException::class);

        $quantity->isGreaterThan($quantityToCompare);

    }

    public function testIsLessThan(): void
    {
        $quantity = QuantityFixtureFactory::get(5);
        $quantityToCompare = QuantityFixtureFactory::get(10);

        $resultTrue = $quantity->isLessThan($quantityToCompare);

        $this->assertTrue($resultTrue);


        $resultFalse = $quantityToCompare->isLessThan($quantity);

        $this->assertFalse($resultFalse);

        $quantity = QuantityFixtureFactory::get(10);
        $quantityToCompare = QuantityFixtureFactory::get(number: 5, metric: MetricFixtureFactory::get('meter', 'm', ''));
        $this->expectException(\InvalidArgumentException::class);

        $quantity->isLessThan($quantityToCompare);
    }

    public function testIsEqualTo(): void
    {
        $quantity = QuantityFixtureFactory::get(10);
        $quantityToCompare = QuantityFixtureFactory::get(10);

        $result = $quantity->isEqualTo($quantityToCompare);

        $this->assertTrue($result);

        $quantityToCompare = QuantityFixtureFactory::get(5);

        $result = $quantity->isEqualTo($quantityToCompare);

        $this->assertFalse($result);

        $quantity = QuantityFixtureFactory::get(10);
        $quantityToCompare = QuantityFixtureFactory::get(number: 5, metric: MetricFixtureFactory::get('meter', 'm', ''));
        $this->expectException(\InvalidArgumentException::class);

        $quantity->isEqualTo($quantityToCompare);
    }
}
