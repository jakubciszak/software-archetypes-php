<?php

namespace SoftwareArchetypesPhp\Rule;

enum RuleElementType
{
    case OPERATOR;
    case PROPOSITION;
    case VARIABLE;

    public function isOnOf(self $type, self ...$others): bool
    {
        return in_array($this, [$type, ...$others], true);
    }
}
