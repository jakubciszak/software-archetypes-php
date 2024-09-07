<?php

namespace SoftwareArchetypesPhp\Rule;

interface RuleElement
{
    public function getName(): string;
    public function getType(): RuleElementType;

    public static function create(string $name): static;
}