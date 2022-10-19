<?php

namespace Majkel\Yafl;

use Majkel\Yafl\Nodes\FunctionNode;
use Majkel\Yafl\Type;
use ParseError;

class Analyzer
{
    /**
     * @var array<string, Type> $variables
     */
    private array $variables = [];

    /**
     * @var array<string, Type> $constants
     */
    private array $constants = [];

    /**
     * @param array<Node> $tree
     */
    public function analyze(array $tree): void
    {
        foreach ($tree as $node) {
            if (!($node instanceof FunctionNode) || !$node->isStatement()) {
                throw new ParseError('Unexpected non-statement structure in top level');
            }

            $node->analyze($this);
        }

        if (!isset($this->constants['entry'])) {
            throw new ParseError('Missing entry constant');
        }
    }

    public function addConstant(string $name, Type $type): static
    {
        $this->constants[$name] = $type;

        return $this;
    }

    public function addVariable(string $name, Type $type): static
    {
        $this->variables[$name] = $type;

        return $this;
    }

    public function free(string $name): static
    {
        unset($this->variables[$name]);
        return $this;
    }

    public function getVariable(string $name): ?Type
    {
        return $this->variables[$name] ?? null;
    }

    public function getConstant(string $name): ?Type
    {
        return $this->constants[$name] ?? null;
    }
}
