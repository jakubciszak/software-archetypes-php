<?php

namespace SoftwareArchetypesPhp\Tests\Quantity\Fixtures;

use SoftwareArchetypesPhp\Quantity\RoundingPolicy;
use SoftwareArchetypesPhp\Quantity\RoundingStrategy;

final readonly class RoundingPolicyFixtureFactory
{
    public static function get(RoundingStrategy $roundingStrategy = RoundingStrategy::ROUND, int $numberOfDigits = 2): RoundingPolicy
    {
        return new RoundingPolicy($roundingStrategy, $numberOfDigits);
    }
}