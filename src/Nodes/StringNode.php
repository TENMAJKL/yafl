<?php

namespace Majkel\Yafl\Nodes;

use Majkel\Yafl\Analyzer;
use Majkel\Yafl\BaseType;
use Majkel\Yafl\Type;

class StringNode implements Node
{
    public function __construct(
        public readonly string $value
    ) {

    }

    public function analyze(Analyzer $analyzer): Type
    {
        return new Type(BaseType::String);
    }

    public function print(): string
    {
        return '"'.$this->value.'"';
    }
}
