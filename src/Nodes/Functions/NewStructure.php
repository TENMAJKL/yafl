<?php

namespace Majkel\Yafl\Nodes\Functions;

use Majkel\Yafl\Analyzer;
use Majkel\Yafl\BaseType;
use Majkel\Yafl\Nodes\FunctionNode;
use Majkel\Yafl\Nodes\KeywordNode;
use Majkel\Yafl\Type;
use ParseError;

class NewStructure extends FunctionNode
{
    public function analyze(Analyzer $analyzer): Type
    {
        if (!(($name = $this->children[0] ?? null) instanceof KeywordNode)) {
            throw new ParseError('Expected structure name as first argument');
        }

        $struct_defined = $analyzer->getStructure($name->content);
        $struct = $struct_defined->body[$name->type] ?? null;
        if (!$struct) {
            throw new ParseError('Constructor '.$name->content.' does not exist');
        }       

        foreach (array_slice($this->children, 1) as $index => $property) {

            $type = $struct->body[$index];
            
            if ($type->type == BaseType::GenericType) {
                $type->setGeneric($property->analyze($analyzer));
            }

            if ($type->type != $property->analyze($analyzer)->type) {
                throw new ParseError('Unexpected type');
            }
        }

        return $struct_defined;        
    }

    public function print(Analyzer $analyzer): string
    {
        $name = $this->children[0];
        $struct_defined = $analyzer->getStructure($name->content);
        $struct = $struct_defined->body[$name->type] ?? null;
        $result = '[';
        foreach (array_slice($this->children, 1) as $index => $property) {
            $result .= $property->print($analyzer).', ';
        }
        return $result.']';
    }
}
