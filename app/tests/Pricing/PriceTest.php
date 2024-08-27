<?php

namespace SoftwareArchetypesPhp\Tests\Pricing;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use SoftwareArchetypesPhp\Pricing\Price;
use SoftwareArchetypesPhp\Pricing\PriceRuleContext;
use SoftwareArchetypesPhp\Tests\Pricing\Fixtures\CurrencyFixtureFactory;
use SoftwareArchetypesPhp\Tests\Pricing\Fixtures\MoneyFixtureFactory;
use SoftwareArchetypesPhp\Tests\Shared\Fixtures\PeriodFixtureFactory;

class PriceTest extends TestCase
{
    public function testValidation(): void
    {
        $price = new Price(
            MoneyFixtureFactory::get(),
            PeriodFixtureFactory::get('2021-06-01', '2021-06-30')
        );

        $this->assertTrue($price->isValid(new PriceRuleContext(
            CurrencyFixtureFactory::getPLN(),
            new DateTimeImmutable('2021-06-20')
        )));

        $this->assertFalse($price->isValid(new PriceRuleContext(
            CurrencyFixtureFactory::getEUR(),
            new DateTimeImmutable('2021-06-20')
        )));

        $this->assertFalse($price->isValid(new PriceRuleContext(
            CurrencyFixtureFactory::getPLN(),
            new DateTimeImmutable('2021-07-20')
        )));
    }

}
