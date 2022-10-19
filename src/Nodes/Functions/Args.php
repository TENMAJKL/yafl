<?php

namespace Majkel\Yafl\Nodes\Functions;

use Majkel\Yafl\Analyzer;
use Majkel\Yafl\Nodes\FunctionNode;
use Majkel\Yafl\Nodes\KeywordNode;
use Majkel\Yafl\Type;
use ParseError;

class Args extends FunctionNode
{
    public function analyze(Analyzer $analyzer): Type
    {

        foreach ($this->children as $argument) {
            if (!($argument instanceof KeywordNode)) {
                throw new ParseError('Argument definition expects only keywords');
            }

        }
    }
}
