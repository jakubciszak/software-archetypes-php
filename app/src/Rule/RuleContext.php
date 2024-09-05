<?php

namespace SoftwareArchetypesPhp\Rule;

use Munus\Collection\Map;

class RuleContext
{
    /**
     * @param Map<RuleElement> $elements
     */
    private Map $elements;

    public function __construct()
    {
        $this->elements = Map::empty();
    }

    public function addElement(RuleElement $ruleElement): self
    {
        $this->elements = $this->elements->put($ruleElement->getName(), $ruleElement);
        return $this;
    }

    public function append(RuleContext $context): self
    {
        $newContext = new RuleContext();
        $newContext->setElements($this->elements->merge($context->elements));
        return $newContext;
    }

    private function setElements(Map $elements): void
    {
        $this->elements = $elements;
    }

    public function findElement(RuleElement $ruleElement): RuleElement
    {
        return $this->elements->get($ruleElement->getName())->get();
    }
}