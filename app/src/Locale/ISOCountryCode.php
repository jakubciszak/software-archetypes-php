<?php

namespace SoftwareArchetypesPhp\Locale;

class ISOCountryCode implements Locale
{
    private static array $instances = [];

    private function __construct(
        private readonly string $officialName,
        private readonly string $alpha3code,
        private readonly string $alpha2code,
    ) {
    }

    public static function create(
        string $officialName,
        string $alpha3code,
        string $alpha2code,
    ): static {
        if (!isset(static::$instances[$alpha3code])) {
            static::$instances[$alpha3code] = new static($officialName, $alpha3code, $alpha2code);
        }
        return static::$instances[$alpha3code];
    }


    public function identifier(): string
    {
        return $this->alpha3code;
    }

    public function name(): string
    {
        return $this->officialName;
    }

    public function alpha2Code(): string
    {
        return $this->alpha2code;
    }
}