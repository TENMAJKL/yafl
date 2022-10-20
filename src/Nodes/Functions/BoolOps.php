<?php

namespace Majkel\Yafl\Nodes\Functions;

use Majkel\Yafl\Analyzer;
use Majkel\Yafl\BaseType;
use Majkel\Yafl\Nodes\FunctionNode;
use Majkel\Yafl\Type;
use ParseError;

class BoolOps extends FunctionNode
{
    public function analyze(Analyzer $analyzer): Type
    {
        if (($this->children[0] ?? null)?->analyze($analyzer)->type !== BaseType::Int) {
            throw new ParseError('Expected number as first argument');
        }

        if (($this->children[1] ?? null)?->analyze($analyzer)->type !== BaseType::Int) {
            throw new ParseError('Expected number as second argument');
        }

        return new Type(BaseType::Bool);
    }

    public function print(): string
    {
        $op = $this->name;
        $op = $op == '/=' ? '!=' : $op;
        return $this->children[0]->print().' '.$op.' '.$this->children[1]->print();
    }
}
