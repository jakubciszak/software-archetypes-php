<?php

namespace SoftwareArchetypesPhp\Tests\Quantity\Fixtures;

use SoftwareArchetypesPhp\Quantity\Metric;
use SoftwareArchetypesPhp\Quantity\Quantity;
use SoftwareArchetypesPhp\Quantity\RoundingPolicy;

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