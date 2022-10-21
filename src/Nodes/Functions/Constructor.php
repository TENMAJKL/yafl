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
        throw new ParseError('Data constructor can be only in data definition');
    }

    public function print(Analyzer $analyzer): string
    {
        return '';
    }

    /**
     * This allows us to have constructor only in data along with recursive data strucutures
     */
    public function analyzeReal(Analyzer $analyzer, Type $self): Type
    {
        $construct = [];
        if (!(($name = $this->children[0] ?? null) instanceof KeywordNode)) {
            throw new ParseError('Expected constructor name as first argument');
        }

        foreach (array_slice($this->children, 1) as $child) {
            if (!($child instanceof KeywordNode)) {
                throw new ParseError('Unexpected token, expected type definition');
            }
            $type = 
                $child->content == $self->name 
                ? $type = $self
                : $type = Type::fromString($child->content, $analyzer)
            ;
        
            $construct[] = $type; 
        }

        return new Type(BaseType::Constructor, $name->content, $construct);
    }
}
