<?php

namespace Majkel\Yafl\Nodes;

use Majkel\Yafl\Analyzer;
use Majkel\Yafl\BaseType;
use Majkel\Yafl\Type;

class NumberNode implements Node
{
    public function __construct(
        public readonly int $value
    ) {

    }

    public function analyze(Analyzer $analyzer): Type
    {
        return new Type(BaseType::Int);
    }

    public function print(): string
    {
        return (string) $this->value;
    }
}
