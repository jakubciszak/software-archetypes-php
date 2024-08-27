<?php

namespace SoftwareArchetypesPhp\Pricing;

use SoftwareArchetypesPhp\Quantity\Metric;

class Currency implements Metric
{
    private static array $instances = [];

    private function __construct(
        private readonly string $name,
        private readonly string $alphaCode,
        private readonly string $majorSymbol,
        private readonly string $minorSymbol,
        private readonly array $locales,
        private readonly string $definition = '',
    ) {
    }


    public function name(): string
    {
        return $this->name;
    }

    public function symbol(): string
    {
        return $this->majorSymbol;
    }

    public function minorSymbol(): string
    {
        return $this->minorSymbol;
    }

    public function definition(): string
    {
        return $this->definition;
    }

    public function alphaCode(): string
    {
        return $this->alphaCode;
    }

    public function acceptedIn(): array
    {
        return $this->locales;
    }

    public static function create(
        string $name,
        string $alphaCode,
        string $majorSymbol,
        string $minorSymbol,
        array $locales,
        string $definition = '',
    ): static {
        if (!isset(static::$instances[$alphaCode])) {
            static::$instances[$alphaCode] = new static(
                $name,
                $alphaCode,
                $majorSymbol,
                $minorSymbol,
                $locales,
                $definition
            );
        }
        return static::$instances[$alphaCode];
    }

    public function equals(Metric $other): bool
    {
        return $this->symbol() === $other->symbol();
    }
}