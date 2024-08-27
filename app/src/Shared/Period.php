<?php

namespace SoftwareArchetypesPhp\Shared;
use DateTimeInterface;

class Period extends \DatePeriod
{
    public function __construct(
        DateTimeInterface $start,
        DateTimeInterface $end,
    ) {
        parent::__construct($start, new \DateInterval('P1D'), $end);
    }
    
    public function contains(DateTimeInterface $dateTime): bool
    {
        return $dateTime >= $this->start && $dateTime <= $this->end;
    }
}