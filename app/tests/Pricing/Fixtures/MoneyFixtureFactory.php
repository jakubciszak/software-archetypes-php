<?php

namespace SoftwareArchetypesPhp\Tests\Pricing\Fixtures;

use SoftwareArchetypesPhp\Pricing\Currency;
use SoftwareArchetypesPhp\Pricing\Money;
use SoftwareArchetypesPhp\Quantity\RoundingPolicy;
use SoftwareArchetypesPhp\Tests\Quantity\Fixtures\RoundingPolicyFixtureFactory;

readonly class MoneyFixtureFactory
{
    public static function get(
        int $amount = 100,
        Currency $currency = null,
        RoundingPolicy $roundingPolicy = null
    ): Money {
        $currency = $currency ?? CurrencyFixtureFactory::getPLN();
        $roundingPolicy = $roundingPolicy ?? RoundingPolicyFixtureFactory::get();
        return new Money($amount, $currency, $roundingPolicy);
    }

}