<?php

namespace Majkel\Yafl\Nodes;

class NumberNode implements Node
{
    public function __construct(
        public readonly int $value
    ) {

    }
}
