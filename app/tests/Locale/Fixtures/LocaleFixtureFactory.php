<?php

namespace SoftwareArchetypesPhp\Tests\Locale\Fixtures;
use SoftwareArchetypesPhp\Locale\ISOCountryCode;
use SoftwareArchetypesPhp\Locale\Locale;

readonly class LocaleFixtureFactory
{
    public static function get(string $name = 'Poland', string $alpha3Code = 'pol', string $alpha2Code = 'PL'): Locale
    {
        return ISOCountryCode::create($name, $alpha3Code, $alpha2Code);
    }

    public static function getPoland(): Locale
    {
        return self::get();
    }

    public static function getGermany(): Locale
    {
        return self::get('Germany', 'ger', 'DE');
    }

    public static function getUnitedStates(): Locale
    {
        return self::get('United States', 'usa', 'US');
    }

}