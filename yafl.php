<?php

use Majkel\Yafl\{Lexer, Parser, Analyzer, Generator};

include __DIR__.'/vendor/autoload.php';

$name = $argv[1] ?? throw new Exception('file does not exist');

$lexer = new Lexer();
$tokens = $lexer->lex(file_get_contents($name));
$parser = new Parser($tokens);
$nodes = $parser->parse();
$analyzer = new Analyzer();
$analyzer->analyze($nodes);
$generator = new Generator();
$result = $generator->generate($nodes, $analyzer);
file_put_contents(explode('.', $name)[0].'.js', $result);
