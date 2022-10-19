<?php

use Majkel\Yafl\{Lexer, Parser};

include __DIR__.'/vendor/autoload.php';

$lexer = new Lexer();
$tokens = $lexer->lex('
(f main (\ parek parek))
');
$parser = new Parser($tokens);
print_r($parser->parse());
