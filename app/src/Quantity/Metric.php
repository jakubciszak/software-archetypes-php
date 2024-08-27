<?php

namespace SoftwareArchetypesPhp\Quantity;

interface Metric
{
    public function name(): string;
    public function symbol(): string;
    public function definition(): string;
    public function equals(Metric $other): bool;
}