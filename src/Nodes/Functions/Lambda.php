<?php

namespace Majkel\Yafl\Nodes\Functions;

use Majkel\Yafl\BaseType;
use Majkel\Yafl\Analyzer;
use Majkel\Yafl\Nodes\FunctionNode;
use Majkel\Yafl\Nodes\KeywordNode;
use Majkel\Yafl\Type;
use ParseError;

class Lambda extends FunctionNode
{
    public function analyze(Analyzer $analyzer): Type
    {
        if (!(($this->children[0] ?? null) instanceof KeywordNode)) {
            throw new ParseError('Expected argument name as first argument');
        }

        if (!$this->children[0]->type) {
            throw new ParseError('Expected type for lambda parameter');
        }

        if (!isset($this->children[1])) {
            throw new ParseError('Expected second argument');
        }

        $analyzer->addVariable($this->children[0]->content, $this->children[0]->type);
        $type = new Type(BaseType::Lambda, null, [
            $this->children[0]->type,
            $this->children[1]->analyze($analyzer)
        ]);

        $analyzer->free($this->children[0]->content);

        return $type;
    }

    public function print(): string
    {
        return '('.$this->children[0]->print().') => '.$this->children[1]->print();
    }
}
