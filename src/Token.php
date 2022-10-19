<?php

namespace Majkel\Yafl;

class Token
{
    public function __construct(
        public readonly TokenKind $kind,
        public readonly string $content,
        public readonly int $line,
    ) {

    }
}
