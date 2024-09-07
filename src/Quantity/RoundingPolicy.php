<?php

namespace SoftwareArchetypesPhp\Quantity;

final readonly class RoundingPolicy
{

    public function __construct(
        public RoundingStrategy $strategy,
        public int $numberOfDigits = 2,
        public int $roundingDigit = 5
    ){
    }

    public function round(float $value): float
    {
        return match ($this->strategy) {
            RoundingStrategy::ROUND_UP => $this->roundUp($value),
            RoundingStrategy::ROUND_DOWN => $this->roundDown($value),
            default => $this->roundDefault($value),
        };

    }

    private function roundUp(float $value): float
    {
        $factor = 10 ** $this->numberOfDigits;
        $scaledNumber = $value * $factor;
        return ceil($scaledNumber) / $factor;
    }

    private function roundDown(float $value): float
    {
        $factor = 10 ** $this->numberOfDigits;
        $scaledNumber = $value * $factor;
        return floor($scaledNumber) / $factor;
    }

    private function roundDefault(float $value): float
    {
        $factor = 10 ** $this->numberOfDigits;
        $scaledNumber = $value * $factor;

        $fractionalPart = $scaledNumber - floor($scaledNumber);
        $nextDigit = (int)($fractionalPart * 10);

        if ($nextDigit >= $this->roundingDigit) {
            return ceil($scaledNumber) / $factor;
        }

        return floor($scaledNumber) / $factor;
    }

}