<?php

namespace Majkel\Yafl\Nodes;

use Majkel\Yafl\Analyzer;
use Majkel\Yafl\BaseType;
use Majkel\Yafl\Type;
use ParseError;

class KeywordNode implements Node
{
    public function __construct(
        public readonly string $content,
        public readonly ?Type $type = null,
    ) {

    }

    public function analyze(Analyzer $analyzer): Type
    { 
        return 
            $analyzer->getType($this->content)
            ?? throw new ParseError('Undefined variable '.$this->content)
        ;
    }
}
