<?php

use Majkel\Yafl\{Lexer, Parser, Analyzer, Generator};

include __DIR__.'/vendor/autoload.php';

$lexer = new Lexer();
$tokens = $lexer->lex('
$(add @(x:int y:int int) +(x y))
$(fac @(x:int int) if(==(x 0) 1 fac(-(x 1))))
$(parek @(int) 10);
$(entry @(int) fac(parek()))
');
$parser = new Parser($tokens);
$nodes = $parser->parse();
$analyzer = new Analyzer();
$analyzer->analyze($nodes);
$generator = new Generator();
echo $generator->generate($nodes);
