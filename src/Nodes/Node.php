<?php

namespace Majkel\Yafl\Nodes;

use Majkel\Yafl\Analyzer;
use Majkel\Yafl\Type;

interface Node
{
    public function analyze(Analyzer $analyzer): Type;
}
