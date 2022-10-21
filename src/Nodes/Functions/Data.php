<?php

namespace Majkel\Yafl\Nodes\Functions;

use Majkel\Yafl\Analyzer;
use Majkel\Yafl\BaseType;
use Majkel\Yafl\Nodes\FunctionNode;
use Majkel\Yafl\Nodes\KeywordNode;
use Majkel\Yafl\Type;
use ParseError;

class Data extends FunctionNode
{
    public function analyze(Analyzer $analyzer): Type
    {
        if (!(($name = $this->children[0] ?? null) instanceof KeywordNode)) {
            throw new ParseError('Expected structure name as first argument');
        }

        $struct = new Type(BaseType::Data, $name->content, []);
        foreach (array_slice($this->children, 1) as $constructor) {
            if (!($constructor instanceof Constructor)) {
                throw new ParseError('Unexpected token, expected constructor');
            }
            $type = $constructor->analyzeReal($analyzer, $struct);
            $struct->body[$type->name] = $type;
        }

        $analyzer->addStructure($name->content, $struct);
        return new Type(BaseType::Void);
    }

    public function print(Analyzer $analyzer): string
    {
        // since js doesnt have structures, objects will be created for every structure creation
        return '';
    }
}
