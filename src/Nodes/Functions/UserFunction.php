<?php

namespace Majkel\Yafl\Nodes\Functions;

use Majkel\Yafl\Analyzer;
use Majkel\Yafl\Nodes\FunctionNode;
use Majkel\Yafl\Type;
use ParseError;

class UserFunction extends FunctionNode
{
    public function analyze(Analyzer $analyzer): Type
    {
        $function = 
            $analyzer->getConstant($this->name) 
            ?? throw new ParseError('Unknown constant '.$this->name)
        ;
        // this will be harder lol        
    }
}
