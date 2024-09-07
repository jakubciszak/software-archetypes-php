<?php

namespace SoftwareArchetypesPhp\Tests\Shared\Fixtures;
use DateTimeImmutable;
use Exception;
use SoftwareArchetypesPhp\Shared\Period;

final readonly class PeriodFixtureFactory
{
    /**
     * @throws Exception
     */
    public static function get(string $from, string $to): Period
    {
        return new Period(
            start: new DateTimeImmutable($from),
            end: new DateTimeImmutable($to),
        );
    }
}