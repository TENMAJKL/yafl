<?php

namespace Majkel\Yafl\Nodes;

class StringNode implements Node
{
    public function __construct(
        public readonly string $value
    ) {

    }
}
