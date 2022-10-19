<?php

use Majkel\Yafl\{Lexer, Parser};

include __DIR__.'/vendor/autoload.php';

$lexer = new Lexer();
$tokens = $lexer->lex('(+ 1 (+ 1 2))');
$parser = new Parser($tokens);
print_r($parser->parse());
