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

        $generics = [];
        $result = Type::fromString($children[0]->content, $analyzer);
        if ($result->type == BaseType::GenericType) {
            $generics[$result->name] = $result;
        }

        foreach (array_slice($children, 1) as $child) {
            if (($type = $child->getType($analyzer)) == null) {
                throw new ParseError('Missing type definition at argument '.$child->name);
            }

            if ($type->type == BaseType::GenericType) {
                if (!isset($generics[$type->name])) {
                    $generics[$type->name] = $type;               
                }

                $type = $generics[$type->name];
            }

            $analyzer->addVariable($child->content, $type);
            $result = new Type(BaseType::Lambda, null, [$type, $result]);
        }
 
        return $result;
    }

    public function print(Analyzer $analyzer): string
    {
        $args = '';
        foreach (array_slice($this->children, 0, -1) as $child) {
            $args .= '('.$child->content.') => ';
        }

        if (!$args) {
            $args = '() => ';
        }

        return $args;
    }
}
