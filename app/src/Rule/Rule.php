<?php

namespace SoftwareArchetypesPhp\Rule;

use Munus\Collection\GenericList;
use SoftwareArchetypesPhp\Rule\Exception\InvalidRuleElementError;

class Rule
{
    /**
     * @param GenericList<RuleElement> $elements
     */
    private GenericList $elements;

    public function __construct(private readonly string $name)
    {
        $this->elements = GenericList::empty();
    }

    public function and(): self
    {
        return $this->addElement(Operator::AND);
    }

    public function or(): self
    {
        return $this->addElement(Operator::OR);
    }

    public function not(): self
    {
        return $this->addElement(Operator::NOT);
    }

    public function equalTo(): self
    {
        return $this->addElement(Operator::EQUAL_TO);
    }

    public function notEqualTo(): self
    {
        return $this->addElement(Operator::NOT_EQUAL_TO);
    }

    public function greaterThan(): self
    {
        return $this->addElement(Operator::GREATER_THAN);
    }

    public function lessThan(): self
    {
        return $this->addElement(Operator::LESS_THAN);
    }

    public function greaterThanOrEqualTo(): self
    {
        return $this->addElement(Operator::GREATER_THAN_OR_EQUAL_TO);
    }

    public function lessThanOrEqualTo(): self
    {
        return $this->addElement(Operator::LESS_THAN_OR_EQUAL_TO);
    }
    
    public function addElement(RuleElement $element): self
    {
        $this->elements = $this->elements->append($element);
        return $this;
    }

    public function evaluate(RuleContext $context): Proposition
    {
        $this->elements->forEach(fn (RuleElement $element) => $this->prepareElement($element, $context));
        return $this->process($this->elements);
    }

    private function prepareElement(RuleElement $element, RuleContext $context): bool
    {
        if ($this->isPropositionOrVariable($element)) {
            $ruleElement = $context->findElement($element);
            /** @var ValueAvailable $ruleElement */
            /** @var ValueAvailable $element  */
            if ($ruleElement->getValue() === null) {
                $ruleElement->setValue($element->getValue());
            }
            $element->setValue($ruleElement->getValue());
        }
        return true;
    }

    private function isPropositionOrVariable(RuleElement $element): bool
    {
        return $element->getType()->isOnOf(RuleElementType::PROPOSITION, RuleElementType::VARIABLE);
    }

    private function process(GenericList $elements): Proposition
    {
        $stack = [];
        $elements->forEach(function (RuleElement $ruleElement) use (&$stack) {
            return $this->processRuleElement($stack, $ruleElement);
        });
        return array_shift($stack);
    }

    private function processRuleElement(array &$stack, RuleElement $ruleElement): bool
    {
        if ($this->isOperator($ruleElement)) {
            /** @var Operator $ruleElement */
            $this->processOperator($stack, $ruleElement);
        } elseif ($this->isPropositionOrVariable($ruleElement)) {
            /** @var Proposition|Variable $ruleElement */
            $this->processPropositionOrVariable($stack, $ruleElement);
        } else {
            throw new InvalidRuleElementError(
                sprintf('Unknown RuleElement type "%s".', $ruleElement->getType()->name)
            );
        }
        return true;
    }

    private function isOperator(RuleElement $ruleElement): bool
    {
        return $ruleElement->getType()->isOnOf(RuleElementType::OPERATOR);
    }

    private function processOperator(array &$stack, Operator $ruleElement): void
    {
        $this->invokePredicate($stack, $ruleElement);
    }

    private function processPropositionOrVariable(array &$stack, RuleElement $ruleElement): void
    {
        $stack = array_merge($stack, [$ruleElement]);
    }

    private function invokePredicate(array &$stack, Operator $operator): void
    {
        if ($operator === Operator::NOT) {
            /** @var Proposition $element */
            $element = array_pop($stack);
            $stack = array_merge($stack, [$element->not()]);
        } else {
            $leftElement = array_pop($stack);
            $rightElement = array_pop($stack);
            $operation = $operator->toOperationName();
            $stack = array_merge($stack, [$leftElement->$operation($rightElement)]);
        }
    }
}