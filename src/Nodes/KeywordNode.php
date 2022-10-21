<?php

namespace Majkel\Yafl\Nodes;

use Majkel\Yafl\Analyzer;
use Majkel\Yafl\Type;
use ParseError;

class KeywordNode implements Node
{
    public function __construct(
        public readonly string $content,
        public readonly ?string $type = null,
    ) {

    }

    public function analyze(Analyzer $analyzer): Type
    {
        return 
            $analyzer->getVariable($this->content)
            ?? throw new ParseError('Undefined variable '.$this->content)
        ;
    }

    public function getType(Analyzer $analyzer): Type
    {
        return Type::fromString($this->type, $analyzer);
    }

    public function print(Analyzer $analyzer): string
    {
        return $this->content;
    }
}
