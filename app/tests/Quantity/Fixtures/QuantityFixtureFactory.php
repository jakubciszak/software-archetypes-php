<?php

namespace SoftwareArchetypesPhp\TestsQuantityFixtures;

use SoftwareArchetypesPhp\Quantity\Domain\Metric;
use SoftwareArchetypesPhp\Quantity\Domain\Quantity;
use SoftwareArchetypesPhp\Quantity\Domain\RoundingPolicy;

class QuantityFixtureFactory
{
    public static function get(
        float $number,
        RoundingPolicy $roundingPolicy = null,
        Metric $metric = null,
    ): Quantity {

        return new Quantity(
            $number,
            $metric ?? MetricFixtureFactory::get(),
            $roundingPolicy ?? RoundingPolicyFixtureFactory::get()
        );
    }

}