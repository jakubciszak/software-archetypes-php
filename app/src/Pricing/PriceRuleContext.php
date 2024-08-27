<?php

namespace SoftwareArchetypesPhp\Pricing;

use DateTimeImmutable;

readonly class PriceRuleContext
{
    public function __construct(
        public Currency $currency,
        public DateTimeImmutable $date
    ) {
    }
}