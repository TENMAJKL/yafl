<?php

namespace Majkel\Yafl\Nodes\Functions;

use Majkel\Yafl\BaseType;
use Majkel\Yafl\Analyzer;
use Majkel\Yafl\Nodes\FunctionNode;
use Majkel\Yafl\Nodes\KeywordNode;
use Majkel\Yafl\Type;
use ParseError;

class Definition extends FunctionNode
{
    public function analyze(Analyzer $analyzer): Type
    {
        if (!(($this->children[0] ?? null) instanceof KeywordNode)) {
            throw new ParseError('Expected name as first argument');
        }

        if (($type = ($this->children[1] ?? null)->analyze($analyzer)) == null) {
            throw new ParseError('Expected type as second argument');
        }
        print_r($this->children);
        if (!isset($this->children[2])) {
            throw new ParseError('Expected body as third argument');
        }

        $analyzer->addConstant($this->children[0]->content, $type);
        $this->children[2]->analyze($analyzer);
        $analyzer->collect();

        return new Type(BaseType::Void);
    }
}
