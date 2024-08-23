<?php

namespace SoftwareArchetypesPhp\TestsQuantityFixtures;

use SoftwareArchetypesPhp\Quantity\Domain\Metric;

final readonly class MetricFixtureFactory
{
    public static function get(
        string $name = 'unit',
        string $symbol = 'u',
        string $definition = ''
    ): Metric {
        return Metric::create($name, $symbol, $definition);
    }
}