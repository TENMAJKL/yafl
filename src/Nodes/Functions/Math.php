<?php

namespace Majkel\Yafl\Nodes\Functions;

use Majkel\Yafl\Analyzer;
use Majkel\Yafl\BaseType;
use Majkel\Yafl\Nodes\FunctionNode;
use Majkel\Yafl\Type;
use ParseError;

class Math extends FunctionNode
{
    public function analyze(Analyzer $analyzer): Type
    {
        if (($this->children[0] ?? null)?->analyze($analyzer)->type !== BaseType::Int) {
            throw new ParseError('Expected number as first argument');
        }

        if (($this->children[1] ?? null)?->analyze($analyzer)->type !== BaseType::Int) {
            throw new ParseError('Expected number as second argument');
        }

        return new Type(BaseType::Int);
    }

    public function print(Analyzer $analyzer): string
    {
        return $this->children[0]->print($analyzer).' '.$this->name.' '.$this->children[1]->print($analyzer);
    }
}
