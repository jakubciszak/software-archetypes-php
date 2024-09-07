<?php

namespace SoftwareArchetypesPhp\Tests\Pricing\Fixtures;
use SoftwareArchetypesPhp\Pricing\Currency;
use SoftwareArchetypesPhp\Tests\Locale\Fixtures\LocaleFixtureFactory;

readonly class CurrencyFixtureFactory
{
    public static function getPLN(): Currency {
        return Currency::create(
            'Polish Zloty',
            'PLN',
            'zł',
            'gr',
            [LocaleFixtureFactory::getPoland()]
        );
    }

    public static function getEUR(): Currency {
        return Currency::create(
            'Euro',
            'EUR',
            '€',
            '',
            [LocaleFixtureFactory::getGermany()]
        );
    }
}