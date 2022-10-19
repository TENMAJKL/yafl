<?php

namespace Majkel\Yafl\Nodes;

class FunctionNode implements Node
{
    public function __construct(
        public readonly string $name,
        /** @var array<Node> $children */
        public readonly array $children,
    ) {

    }
}
