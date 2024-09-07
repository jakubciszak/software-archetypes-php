<?php

namespace SoftwareArchetypesPhp\Pricing;
class CurrencyConverter
{
    private array $exchangeRates = [];

    public function addExchangeRate(ExchangeRate $exchangeRate): self
    {
        $this->exchangeRates[] = $exchangeRate;
        return $this;
    }

    public function getExchangeRates(
        Currency $from,
        Currency $to,
        \DateTimeImmutable $validFrom,
        \DateTimeImmutable $validTo
    ): array {
        $rates = array_filter(
            $this->exchangeRates,
            fn (ExchangeRate $rate) => $rate->from() === $from
                && $rate->to() === $to
                && $rate->isApplicable($validFrom)
                && $rate->isApplicable($validTo)
        );
        usort(
            $rates,
            fn (ExchangeRate $a, ExchangeRate $b) => $b->validTo() <=> $a->validTo()
        );
        return $rates;
    }

    public function exchange(
        Money $amount,
        Currency $to,
        ExchangeRate $rate
    ): Money {
        $convertedAmount = $amount->amount() * $rate->rate();
        return Money::from($amount, $to, $convertedAmount);
    }

    public function getExchangeRateForDate(
        Currency $from,
        Currency $to,
        \DateTimeImmutable $date,
    ): ExchangeRate {
        $rates = $this->getExchangeRates($from, $to, $date, $date);
        return reset($rates);
    }
}