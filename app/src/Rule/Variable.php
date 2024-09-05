<?php

namespace SoftwareArchetypesPhp\Rule;

class Variable implements RuleElement
{
    use ValueAvailable;

    public function __construct(private readonly string $name, mixed $value)
    {
        $this->value = $value;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): RuleElementType
    {
        return RuleElementType::VARIABLE;
    }

    public static function create(string $name, mixed $value = null): static
    {
        return new self($name, $value);
    }

    public function equalTo(self $variable): Proposition
    {
        return Proposition::create(
            sprintf('%s_equalTo_%s', $this->getName(), $variable->getName()),
            $this->value === $variable->value
        );

    }

    public function notEqualTo(self $variable): Proposition
    {
        return Proposition::create(
            sprintf('%s_notEqualTo_%s', $this->getName(), $variable->getName()),
            $this->value !== $variable->value
        );
    }

    public function greaterThan(self $variable): Proposition
    {
        return Proposition::create(
            sprintf('%s_greaterThan_%s', $this->getName(), $variable->getName()),
            $this->value > $variable->value
        );
    }

    public function lessThan(self $variable): Proposition
    {
        return Proposition::create(
            sprintf('%s_lessThan_%s', $this->getName(), $variable->getName()),
            $this->value < $variable->value
        );
    }

    public function greaterThanOrEqualTo(self $variable): Proposition
    {
        return Proposition::create(
            sprintf('%s_greaterThanOrEqualTo_%s', $this->getName(), $variable->getName()),
            $this->value >= $variable->value
        );

    }

    public function lessThanOrEqualTo(self $variable): Proposition
    {
        return Proposition::create(
            sprintf('%s_lessThanOrEqualTo_%s', $this->getName(), $variable->getName()),
            $this->value <= $variable->value
        );
    }
}