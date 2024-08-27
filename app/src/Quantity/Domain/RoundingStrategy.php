<?php

namespace SoftwareArchetypesPhp\Quantity\Domain;

enum RoundingStrategy
{
    case ROUND;
    case ROUND_UP;
    case ROUND_DOWN;
}
