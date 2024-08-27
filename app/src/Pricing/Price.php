<?php

namespace SoftwareArchetypesPhp\Pricing;
use SoftwareArchetypesPhp\Shared\Period;

readonly class Price
{
    public function __construct(
        private Money $amount,
        private Period $validFor
    ) {
    }

    public function amount(): float
    {
        return $this->amount->amount();
    }

    public function currency(): Currency
    {
        return $this->amount->currency();
    }

    public function isValid(PriceRuleContext $businessContext): bool
    {
        return $this->validFor->contains($businessContext->date)
            && $this->amount->currency()->equals($businessContext->currency);
    }
}