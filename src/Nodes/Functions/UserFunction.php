<?php

namespace Majkel\Yafl\Nodes\Functions;

use Majkel\Yafl\Analyzer;
use Majkel\Yafl\BaseType;
use Majkel\Yafl\Nodes\FunctionNode;
use Majkel\Yafl\Type;
use ParseError;

class UserFunction extends FunctionNode
{
    public function analyze(Analyzer $analyzer): Type
    {
        $function = 
            $analyzer->getConstant($this->name) 
            ?? $analyzer->getVariable($this->name)
            ?? throw new ParseError('Unknown constant '.$this->name)
        ;

        $generics = [];

        foreach ($this->children as $argument) {

            $type = $function->body[0];
            
            if ($type->type == BaseType::GenericType) {
                $type->setGeneric($argument->analyze($analyzer));
            }


            if ($type->type != $argument->analyze($analyzer)->type) {
                throw new ParseError('Unexpected type');
            }
 
            $function = $function->body[1];
        }

        return $function;
    }

    public function print(): string
    {
        $args = '';
        foreach ($this->children as $child) {
            $args .= '('.$child->print().')';
        }
        return $this->name.$args;
    }
}
