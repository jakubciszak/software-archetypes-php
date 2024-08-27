<?php

namespace SoftwareArchetypesPhp\TestsQuantityFixtures;

use SoftwareArchetypesPhp\Quantity\Domain\RoundingPolicy;
use SoftwareArchetypesPhp\Quantity\Domain\RoundingStrategy;

final readonly class RoundingPolicyFixtureFactory
{
    public static function get(RoundingStrategy $roundingStrategy = RoundingStrategy::ROUND, int $numberOfDigits = 2): RoundingPolicy
    {
        return new RoundingPolicy($roundingStrategy, $numberOfDigits);
    }
}