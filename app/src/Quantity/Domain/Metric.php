<?php

namespace SoftwareArchetypesPhp\Quantity\Domain;

class Metric
{
    /**
     * @var Metric[]
     */
    protected static array $instances = [];

    private function __construct(
        public readonly string $name,
        public readonly string $symbol,
        public readonly string $definition
    ) {
    }

    public static function create(
        string $name,
        string $symbol,
        string $definition = ''
    ): static {
        if (!isset(static::$instances[$name])) {
            static::$instances[$name] = new static($name, $symbol, $definition);
        }
        return static::$instances[$name];
    }
}