<?php

namespace Majkel\Yafl\Nodes\Functions;

use Majkel\Yafl\Analyzer;
use Majkel\Yafl\Nodes\FunctionNode;
use Majkel\Yafl\Type;

class NewStructure extends FunctionNode
{
    public function analyze(Analyzer $analyzer): Type
    {
        // new(Maybe Just "Majkel") => TODO remove named structures
    }
}
