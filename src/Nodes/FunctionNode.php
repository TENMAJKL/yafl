<?php

namespace Majkel\Yafl\Nodes;

abstract class FunctionNode implements Node
{
    public function __construct(
        public readonly string $name,
        /** @var array<Node> $children */
        public readonly array $children,
    ) {

    }

    public function isStatement(): bool
    {
        return in_array($this->name, [
            '$', 'data',
        ]);
    }
}
