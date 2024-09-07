<?php

namespace SoftwareArchetypesPhp\Pricing;

use SoftwareArchetypesPhp\Locale\Locale;
use SoftwareArchetypesPhp\Quantity\Quantity;
use SoftwareArchetypesPhp\Quantity\RoundingPolicy;

readonly class Money extends Quantity
{
    public function __construct(float $amount, Currency $metric, RoundingPolicy $roundingPolicy)
    {
        parent::__construct($amount, $metric, $roundingPolicy);
    }

    public static function from(self $money, Currency $to, float $convertedAmount): static
    {
        return new self($convertedAmount, $to, $money->roundingPolicy);
    }
    
    public function currency(): Currency
    {
        return $this->metric;
    }

    public function acceptedIn(): array
    {
        return $this->currency()->acceptedIn();
    }

    public function isAcceptedIn(Locale $locale): bool
    {
        $acceptedIn = array_map(fn (Locale $locale) => $locale->identifier(), $this->acceptedIn());
        return in_array($locale->identifier(), $acceptedIn, true);
    }
}