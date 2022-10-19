<?php

namespace Majkel\Yafl\Nodes\Functions;

use Majkel\Yafl\Analyzer;
use Majkel\Yafl\BaseType;
use Majkel\Yafl\Nodes\FunctionNode;
use Majkel\Yafl\Nodes\KeywordNode;
use Majkel\Yafl\Type;
use ParseError;

class TypeDefinition extends FunctionNode 
{
    public function analyze(Analyzer $analyzer): Type
    {
        $children = array_reverse($this->children);
        if (!(($children[0] ?? null) instanceof KeywordNode)) {
            throw new ParseError('Expected return type as first argument');
        }

        $result = Type::fromString($this->children[0]->content);

        foreach (array_slice($children, 1) as $child) {
            if ($child->type == null) {
                throw new ParseError('Missing type definition at argument '.$child->name);
            }
            $analyzer->addVariable($child->content, $child->type);
            $result = new Type(BaseType::Lambda, null, [$child->type, $result]);
        }
        
        return $result;
    }
}
