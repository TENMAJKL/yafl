<?php

namespace Majkel\Yafl\Nodes;

class KeywordNode implements Node
{
    public function __construct(
        public readonly string $content
    ) {

    }
}
