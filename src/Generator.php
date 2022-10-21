<?php

namespace Majkel\Yafl;

class Generator
{
    /**
     * @param array<Node> $tree
     */
    public function generate(array $tree, Analyzer $analyzer): string
    {
        $result = '';
        foreach ($tree as $node) {
            $result .= $node->print($analyzer);
        }

        $result .= 'console.log(entry())';

        return $result;
    }
    
}
