<?php

namespace SoftwareArchetypesPhp\Rule;

readonly class Ruleset
{
    /**
     * @var Rule[]
     */
    private array $rules;

    public function __construct(
        Rule ...$rules
    ) {
        $this->rules = $rules;
    }

    public function evaluate(RuleContext $context): bool
    {
        $result = true;
        foreach ($this->rules as $rule) {
            $result = $rule->evaluate($context);
            if ($result->getValue() === false) {
                return false;
            }
        }
        return $result;
    }
}