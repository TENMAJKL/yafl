<?php

namespace Majkel\Yafl;

use Majkel\Yafl\Nodes\{StringNode, NumberNode, FunctionNode, KeywordNode, Node};
use ParseError;

class Parser
{
    public function __construct(
        public readonly Stream $tokens
    ) {

    }

    public function parse(): array
    {
        $tokens = [];
        while ($this->tokens->curent()) {
            $tokens[] = $this->parseToken();
            $this->tokens->move();
        }
        return $tokens;
    }

    public function parseToken(): Node
    {
        return 
            $this->parseString() 
            ?? $this->parseNumber() 
            ?? $this->parseFunction()
            ?? $this->parseKeyword()
            ?? throw new ParseError('Unexpected token '.$this->tokens->curent()?->content)
        ;
    }

    public function parseKeyword(): ?KeywordNode
    {
        if ($this->tokens->curent()?->kind != TokenKind::Keyword) {
            return null;
        }

        return new KeywordNode($this->tokens->curent()->content);
    }

    public function parseString(): ?StringNode
    {
        if ($this->tokens->curent()?->kind != TokenKind::String) {
            return null;
        }

        return new StringNode($this->tokens->curent()->content);
    }

    public function parseNumber(): ?NumberNode
    {
        if ($this->tokens->curent()?->kind != TokenKind::Number) {
            return null;
        }

        return new NumberNode($this->tokens->curent()->content);       
    }

    public function parseFunction(): ?FunctionNode
    {
        if ($this->tokens->curent()?->kind != TokenKind::Keyword
            || $this->tokens->peek()?->kind != TokenKind::Open
        ) {
            return null;
        }

        $name = $this->tokens->curent();
        $this->tokens->move(2);

        $children = [];
        while ($this->tokens->curent()?->kind !== TokenKind::Close) {
            $children[] = $this->parseToken();
            $this->tokens->move();
        }

        return new FunctionNode($name->content, $children);
    }
}
