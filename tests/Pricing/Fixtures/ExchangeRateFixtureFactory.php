<?php

namespace SoftwareArchetypesPhp\Tests\Pricing\Fixtures;

use Exception;
use SoftwareArchetypesPhp\Pricing\ExchangeRate;
use SoftwareArchetypesPhp\Tests\Shared\Fixtures\PeriodFixtureFactory;

readonly class ExchangeRateFixtureFactory
{
    /**
     * @throws Exception
     */
    public static function getPLNtoEUR(float $rate, string $validFrom, string $validTo): ExchangeRate
    {
        return new ExchangeRate(
            rate: $rate,
            validFor: PeriodFixtureFactory::get($validFrom, $validTo),
            from: CurrencyFixtureFactory::getPLN(),
            to: CurrencyFixtureFactory::getEUR(),
        );
    }

    /**
     * @throws Exception
     */
    public static function getEURtoPLN(float $rate, string $validFrom, string $validTo): ExchangeRate
    {
        return new ExchangeRate(
            rate: $rate,
            validFor: PeriodFixtureFactory::get($validFrom, $validTo),
            from: CurrencyFixtureFactory::getEUR(),
            to: CurrencyFixtureFactory::getPLN(),
        );
    }
}
