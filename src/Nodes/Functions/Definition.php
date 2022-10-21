<?php

namespace Majkel\Yafl\Nodes\Functions;

use Majkel\Yafl\BaseType;
use Majkel\Yafl\Analyzer;
use Majkel\Yafl\Nodes\FunctionNode;
use Majkel\Yafl\Nodes\KeywordNode;
use Majkel\Yafl\Type;
use ParseError;

class Definition extends FunctionNode
{
    public function analyze(Analyzer $analyzer): Type
    {
        if (!(($this->children[0] ?? null) instanceof KeywordNode)) {
            throw new ParseError('Expected name as first argument');
        }

        if (($type = ($this->children[1] ?? null)->analyze($analyzer)) == null) {
            throw new ParseError('Expected type as second argument');
        }

        if (!isset($this->children[2])) {
            throw new ParseError('Expected body as third argument');
        }

        $analyzer->addConstant($this->children[0]->content, $type);
        if ($this->children[2]->analyze($analyzer)->type != Type::getLambdaReturn($type)->type) {
            throw new ParseError('Constant '.$this->children[0]->content.' has diffenet type than its definition');
        }
        $analyzer->collect();

        return new Type(BaseType::Void);
    }

    public function print(Analyzer $analyzer): string
    {
        return 'const '.$this->children[0]->print($analyzer).' = '.$this->children[1]->print($analyzer).$this->children[2]->print($analyzer)."\n";
    }
}
