<?php

use Majkel\Yafl\{Lexer, Parser};
use Majkel\Yafl\Analyzer;

include __DIR__.'/vendor/autoload.php';

$lexer = new Lexer();
$tokens = $lexer->lex('
$(cs \(x:int cs(x)))
$(add \(x:int \(y:int +(x y))))
$(entry add(1 2))
');
$parser = new Parser($tokens);
$analyzer = new Analyzer();
$analyzer->analyze($parser->parse());
