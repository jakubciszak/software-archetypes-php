<?php

namespace SoftwareArchetypesPhp\Quantity\Domain;

readonly class Quantity
{
    public function __construct(
        public float $amount,
        private Metric $metric,
        private RoundingPolicy $roundingPolicy
    ) {
    }

    public function add(Quantity $quantity): static
    {
        $this->checkMetric($quantity);
        return $this->fromNumber($this->amount + $quantity->amount);
    }

    public function subtract(Quantity $quantity): static
    {
        $this->checkMetric($quantity);
        return $this->fromNumber($this->amount - $quantity->amount);
    }

    public function multiply(float|Quantity $multiplier): static
    {
        if ($multiplier instanceof self) {
            $this->checkMetric($multiplier);
            $multiplier = $multiplier->amount;
        }
        return $this->fromNumber($this->amount * $multiplier);
    }

    public function divide(float|Quantity $divisor): static
    {
        if ($divisor instanceof self) {
            $this->checkMetric($divisor);
            $divisor = $divisor->amount;
        }
        if ($divisor === 0.0) {
            throw new \DivisionByZeroError('Can not divide by zero');
        }
        return $this->fromNumber($this->amount / $divisor);
    }

    public function isGreaterThan(Quantity $quantity): bool
    {
        $this->checkMetric($quantity);
        return $this->amount > $quantity->amount;
    }

    public function isLessThan(Quantity $quantity): bool
    {
        $this->checkMetric($quantity);
        return $this->amount < $quantity->amount;
    }

    public function isEqualTo(Quantity $quantity): bool
    {
        $this->checkMetric($quantity);
        return $this->amount === $quantity->amount;
    }

    private function checkMetric(Quantity $quantity): void
    {
        if ($this->metric !== $quantity->metric) {
            throw new \InvalidArgumentException('Can not make operations on quantities with different metrics');
        }
    }

    private function fromNumber(float $number): static
    {
        return new static($number, $this->metric, $this->roundingPolicy);
    }

    public function value(): float
    {
        return $this->roundingPolicy->round($this->amount);
    }

    public function symbol(): string
    {
        return $this->metric->symbol;
    }
}