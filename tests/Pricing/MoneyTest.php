<?php

namespace SoftwareArchetypesPhp\Tests\Pricing;

use PHPUnit\Framework\TestCase;
use SoftwareArchetypesPhp\Tests\Locale\Fixtures\LocaleFixtureFactory;
use SoftwareArchetypesPhp\Tests\Pricing\Fixtures\CurrencyFixtureFactory;
use SoftwareArchetypesPhp\Tests\Pricing\Fixtures\MoneyFixtureFactory;

class MoneyTest extends TestCase
{
    public function testAcceptable(): void
    {
        $money = MoneyFixtureFactory::get(100, CurrencyFixtureFactory::getPLN());

        self::assertTrue($money->isAcceptedIn(LocaleFixtureFactory::getPoland()));
        self::assertFalse($money->isAcceptedIn(LocaleFixtureFactory::getGermany()));
    }

}
