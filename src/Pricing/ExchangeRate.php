<?php

namespace SoftwareArchetypesPhp\Pricing;

use DateTimeImmutable;
use SoftwareArchetypesPhp\Shared\Period;

readonly class ExchangeRate
{
    public function __construct(
        private float $rate,
        private Period $validFor,
        private Currency $from,
        private Currency $to,
    ) {}

    public function rate(): float
    {
        return $this->rate;
    }

    public function from(): Currency
    {
        return $this->from;
    }

    public function to(): Currency
    {
        return $this->to;
    }

    public function validFrom(): DateTimeImmutable
    {
        return DateTimeImmutable::createFromInterface($this->validFor->start);
    }

    public function validTo(): DateTimeImmutable
    {
        return DateTimeImmutable::createFromInterface($this->validFor->end);
    }

    public function isApplicable(DateTimeImmutable $date): bool
    {
        return $this->validFor->contains($date);
    }
}