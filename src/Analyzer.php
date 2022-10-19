<?php

namespace Majkel\Yafl;

use Majkel\Yafl\Nodes\FunctionNode;
use ParseError;

class Analyzer
{
    /**
     * @param array<Node> $ast
     */
    public function analyze(array $ast): void
    {
        foreach ($ast as $node) {
            if (!($node instanceof FunctionNode) || $node->name !== '$') {
                throw new ParseError('Top level can contain only constant definitions');
            }
        }
    }
}
