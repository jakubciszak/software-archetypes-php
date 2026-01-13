<?php

declare(strict_types=1);

namespace SoftwareArchetypes\Availability\SimpleAvailability\Commands;

final readonly class Withdraw implements Command
{
    public const TYPE = 'WITHDRAW';

    public function __construct(
        public string $assetId
    ) {
    }

    public function getType(): string
    {
        return self::TYPE;
    }
}
