<?php

namespace SoftwareArchetypesPhp\Tests\Quantity\Fixtures;

use SoftwareArchetypesPhp\Quantity\Metric;

final class MetricFixtureFactory
{
    private static array $metrics = [];

    public static function get(
        string $name = 'unit',
        string $symbol = 'u',
        string $definition = ''
    ): Metric {
        if (!isset(self::$metrics[$name])) {
            self::$metrics[$name] = self::create($name, $symbol, $definition);
        }
        return self::$metrics[$name];
    }

    private static function create(
        string $name = 'unit',
        string $symbol = 'u',
        string $definition = ''
    ): Metric {
        return new readonly class ($name, $symbol, $definition) implements Metric {
            public function __construct(
                private string $name,
                private string $symbol,
                private string $definition
            ) {
            }

            public function name(): string
            {
                return $this->name;
            }

            public function symbol(): string
            {
                return $this->symbol;
            }

            public function definition(): string
            {
                return $this->definition;
            }

            public function equals(Metric $other): bool
            {
                return $this->name() === $other->name();
            }
        };
    }
}