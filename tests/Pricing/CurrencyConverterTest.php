<?php

namespace SoftwareArchetypesPhp\Tests\Pricing;

use DateTimeImmutable;
use Exception;
use PHPUnit\Framework\TestCase;
use SoftwareArchetypesPhp\Pricing\CurrencyConverter;
use SoftwareArchetypesPhp\Tests\Pricing\Fixtures\CurrencyFixtureFactory;
use SoftwareArchetypesPhp\Tests\Pricing\Fixtures\ExchangeRateFixtureFactory;
use SoftwareArchetypesPhp\Tests\Pricing\Fixtures\MoneyFixtureFactory;

class CurrencyConverterTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testExchange(): void
    {
        $converter = new CurrencyConverter();
        $exchangeRate1 = ExchangeRateFixtureFactory::getPLNtoEUR(
            rate: 0.3,
            validFrom: '2024-08-01',
            validTo: '2024-08-02'
        );

        $exchangeRate2 = ExchangeRateFixtureFactory::getPLNtoEUR(
            rate: 0.5,
            validFrom: '2024-08-02',
            validTo: '2024-08-03'
        );
        $converter->addExchangeRate($exchangeRate1)->addExchangeRate($exchangeRate2);
        $rate = $converter->getExchangeRateForDate(
            CurrencyFixtureFactory::getPLN(),
            CurrencyFixtureFactory::getEUR(),
            new DateTimeImmutable('2024-08-02'),
        );

        $money = MoneyFixtureFactory::get(50, CurrencyFixtureFactory::getPLN());

        $convertedMoney = $converter->exchange($money, CurrencyFixtureFactory::getEUR(), $rate);


        $this->assertEquals(25, $convertedMoney->amount());
        $this->assertEquals('EUR', $convertedMoney->currency()->alphaCode());
    }

}
