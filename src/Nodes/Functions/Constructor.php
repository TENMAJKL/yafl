<?php

namespace Majkel\Yafl\Nodes\Functions;

use Majkel\Yafl\Analyzer;
use Majkel\Yafl\BaseType;
use Majkel\Yafl\Nodes\FunctionNode;
use Majkel\Yafl\Nodes\KeywordNode;
use Majkel\Yafl\Type;
use ParseError;

class Constructor extends FunctionNode
{
    public function analyze(Analyzer $analyzer): Type
    {
        $construct = [];
        if (!(($name = $this->children[0] ?? null) instanceof KeywordNode)) {
            throw new ParseError('Expected constructor name as first argument');
        }

        foreach (array_slice($this->children, 1) as $child) {
            if (!($child instanceof KeywordNode)) {
                throw new ParseError('Unexpected token, expected type definition');
            }
            $type = $child->getType($analyzer);
            $construct[$child->content] = $type; 
        }

        return new Type(BaseType::Constructor, $name->content, $construct);
    }

    public function print(Analyzer $analyzer): string
    {
        return '';
    }
}
