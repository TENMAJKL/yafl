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

        if (!isset($this->children[1])) {
            throw new ParseError('Expected second argument');
        }

        $analyzer->addConstant($this->children[0]->content, $this->children[1]->analyze($analyzer));

        return new Type(BaseType::Void);
    }
}
