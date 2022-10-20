<?php

namespace Majkel\Yafl;

class Generator
{
    /**
     * @param array<Node> $tree
     */
    public function generate(array $tree): string
    {
        $result = '';
        foreach ($tree as $node) {
            $result .= $node->print();
        }

        $result .= 'console.log(entry(read_line()))';

        return $result;
    }
    
}
