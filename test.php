<?php

use Majkel\Yafl\{Lexer, Parser};
use Majkel\Yafl\Analyzer;

include __DIR__.'/vendor/autoload.php';

$lexer = new Lexer();
$tokens = $lexer->lex('
$(add \(x:int \(y:int +(x y))))
$(parek add(1))
$(entry parek(2))
');
$parser = new Parser($tokens);
$analyzer = new Analyzer();
$analyzer->analyze($parser->parse());
print_r($analyzer);
