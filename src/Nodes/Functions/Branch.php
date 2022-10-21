<?php

namespace Majkel\Yafl\Nodes\Functions;

use Majkel\Yafl\Analyzer;
use Majkel\Yafl\BaseType;
use Majkel\Yafl\Nodes\FunctionNode;
use Majkel\Yafl\Type;
use ParseError;

class Branch extends FunctionNode
{
    public function analyze(Analyzer $analyzer): Type
    {
        if (($this->children[0] ?? null)?->analyze($analyzer)->type !== BaseType::Bool) {
            throw new ParseError('Expected bool as first argument');
        }

        if (($type = ($this->children[1] ?? null)->analyze($analyzer)) == null) {
            throw new ParseError('Expected second argument');
        }

        if (($this->children[2] ?? null)->analyze($analyzer) != $type) {
            throw new ParseError('Expected third argument with same type as first');
        }

        return $type;
    }   

    public function print(Analyzer $analyzer): string
    {
        return $this->children[0]->print($analyzer).' ? '.$this->children[1]->print($analyzer).' : '.$this->children[2]->print($analyzer);
    } 
}
