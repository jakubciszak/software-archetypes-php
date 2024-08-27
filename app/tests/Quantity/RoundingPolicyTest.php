<?php

namespace SoftwareArchetypesPhp\Tests\Quantity;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use SoftwareArchetypesPhp\Quantity\RoundingPolicy;
use SoftwareArchetypesPhp\Quantity\RoundingStrategy;

class RoundingPolicyTest extends TestCase
{
    #[DataProvider('roundUpData')]
    public function testRoundUp(float $number, int $digits, float $expected): void
    {
        $roundingPolicy = new RoundingPolicy(RoundingStrategy::ROUND_UP, $digits);

        $this->assertEquals($expected, $roundingPolicy->round($number));
    }

    public static function roundUpData(): array
    {
        return [
            ['number' => 0.5, 'digits' => 0, 'expected' => 1.0],
            ['number' => 0.5, 'digits' => 1, 'expected' => 0.5],
            ['number' => 123.456, 'digits' => -2, 'expected' => 200],
            ['number' => 163.456, 'digits' => -2, 'expected' => 200],
            ['number' => 123.456, 'digits' => -1, 'expected' => 130],
            ['number' => 127.456, 'digits' => -1, 'expected' => 130],
            ['number' => 125.456, 'digits' => -1, 'expected' => 130],
            ['number' => 123.456, 'digits' => 0, 'expected' => 124],
            ['number' => 123.556, 'digits' => 0, 'expected' => 124],
            ['number' => 123.656, 'digits' => 0, 'expected' => 124],
            ['number' => 123.456, 'digits' => 1, 'expected' => 123.5],
            ['number' => 123.456, 'digits' => 2, 'expected' => 123.46],
            ['number' => 123.456, 'digits' => 3, 'expected' => 123.456],
        ];
    }

    #[DataProvider('roundDownData')]
    public function testRoundDown(float $number, int $digits, float $expected): void
    {
        $roundingPolicy = new RoundingPolicy(RoundingStrategy::ROUND_DOWN, $digits);

        $this->assertEquals($expected, $roundingPolicy->round($number));
    }

    public static function roundDownData(): array
    {
        return [
            ['number' => 0.5, 'digits' => 0, 'expected' => 0],
            ['number' => 0.5, 'digits' => 1, 'expected' => 0.5],
            ['number' => 123.456, 'digits' => -2, 'expected' => 100],
            ['number' => 163.456, 'digits' => -2, 'expected' => 100],
            ['number' => 123.456, 'digits' => -1, 'expected' => 120],
            ['number' => 127.456, 'digits' => -1, 'expected' => 120],
            ['number' => 125.456, 'digits' => -1, 'expected' => 120],
            ['number' => 123.456, 'digits' => 0, 'expected' => 123],
            ['number' => 123.556, 'digits' => 0, 'expected' => 123],
            ['number' => 123.656, 'digits' => 0, 'expected' => 123],
            ['number' => 123.456, 'digits' => 1, 'expected' => 123.4],
            ['number' => 123.456, 'digits' => 2, 'expected' => 123.45],
            ['number' => 123.456, 'digits' => 3, 'expected' => 123.456],
        ];
    }

    #[DataProvider('roundDefaultData')]
    public function testRoundDefault(float $number, int $digits, int $roundingDigit, float $expected): void
    {
        $roundingPolicy = new RoundingPolicy(RoundingStrategy::ROUND, $digits, $roundingDigit);

        $this->assertEquals($expected, $roundingPolicy->round($number));
    }

    public static function roundDefaultData(): array
    {
        return [
            ['number' => 123.456, 'digits' => 0, 'roundingDigit' => 5, 'expected' => 123],
            ['number' => 123.456, 'digits' => 0, 'roundingDigit' => 4, 'expected' => 124],
            ['number' => 123.456, 'digits' => 0, 'roundingDigit' => 3, 'expected' => 124],
            ['number' => 123.456, 'digits' => 1, 'roundingDigit' => 5, 'expected' => 123.5],
            ['number' => 123.456, 'digits' => 1, 'roundingDigit' => 6, 'expected' => 123.4],
            ['number' => 123.456, 'digits' => 2, 'roundingDigit' => 5, 'expected' => 123.46],
            ['number' => 123.456, 'digits' => 2, 'roundingDigit' => 6, 'expected' => 123.46],
            ['number' => 123.456, 'digits' => 2, 'roundingDigit' => 7, 'expected' => 123.45],
        ];
    }
}
