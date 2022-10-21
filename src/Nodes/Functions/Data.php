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

        $struct = [];
        foreach (array_slice($this->children, 1) as $constructor) {
            if (($type = $constructor->analyze($analyzer))->type != BaseType::Constructor) {
                throw new ParseError('Unexpected token, expected constructor');
            }
            $struct[$type->name] = $type;
        }

        $struct = new Type(BaseType::Data, $name->content, $struct);
        $analyzer->addStructure($name->content, $struct);
        return new Type(BaseType::Void);
    }

    public function print(Analyzer $analyzer): string
    {
        // since js doesnt have structures, objects will be created for every structure creation
        return '';
    }
}
