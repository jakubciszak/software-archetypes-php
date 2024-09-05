<?php

namespace SoftwareArchetypesPhp\Rule;

use Closure;

trait ValueAvailable
{
    private mixed $value;

    public function getValue(): mixed
    {
        if ($this->value instanceof Closure) {
            return call_user_func($this->value);
        }
        return $this->value;
    }

    public function setValue(mixed $value): void
    {
        $this->value = $value;
    }
}