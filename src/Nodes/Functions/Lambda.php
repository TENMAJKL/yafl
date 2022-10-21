<?php

namespace Majkel\Yafl\Nodes\Functions;

use Majkel\Yafl\BaseType;
use Majkel\Yafl\Analyzer;
use Majkel\Yafl\Nodes\FunctionNode;
use Majkel\Yafl\Nodes\KeywordNode;
use Majkel\Yafl\Type;
use ParseError;

class Lambda extends FunctionNode
{
    public function analyze(Analyzer $analyzer): Type
    {
        if (!(($arg = $this->children[0] ?? null) instanceof KeywordNode)) {
            throw new ParseError('Expected argument name as first argument');
        }

        /** @var KeywordNode $arg */

        $fn_type = $arg->getType();
        if (!$fn_type) {
            throw new ParseError('Expected type for lambda parameter');
        }

        if (!isset($this->children[1])) {
            throw new ParseError('Expected second argument');
        }
        
        $analyzer->addVariable($arg->content, $fn_type);
        $type = new Type(BaseType::Lambda, null, [
            $fn_type,
            $this->children[1]->analyze($analyzer)
        ]);

        $analyzer->free($this->children[0]->content);

        return $type;
    }

    public function print(Analyzer $analyzer): string
    {
        return '('.$this->children[0]->print($analyzer).') => '.$this->children[1]->print($analyzer);
    }
}
