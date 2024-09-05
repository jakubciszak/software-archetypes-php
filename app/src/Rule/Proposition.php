<?php

namespace SoftwareArchetypesPhp\Rule;

use Closure;

class Proposition implements RuleElement
{
    use ValueAvailable;

    public function __construct(private readonly string $name, Closure|bool $value)
    {
        $this->value = $value;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): RuleElementType
    {
        return RuleElementType::PROPOSITION;
    }

    public static function create(string $name, Closure|bool $value = true): static
    {
        return new self($name, $value);
    }

    public function and(self $proposition): Proposition
    {
        return self::create(
            sprintf('%s_and_%s', $this->getName(), $proposition->getName()),
            $this->value && $proposition->value
        );
    }

    public function or(self $proposition): Proposition
    {
        return self::create(
            sprintf('%s_or_%s', $this->getName(), $proposition->getName()),
            $this->value || $proposition->value
        );
    }

    public function not(): Proposition
    {
        return self::create(
            sprintf('not_%s', $this->getName()),
            !$this->value
        );
    }
}