<?php

namespace SoftwareArchetypesPhp\Locale;

interface Locale
{
   public function identifier(): string;
   public function name(): string;
}