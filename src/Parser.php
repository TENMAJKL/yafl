<?php

namespace Majkel\Yafl;

use Majkel\Yafl\Nodes\{StringNode, NumberNode, FunctionNode, KeywordNode, Node};
use Majkel\Yafl\Nodes\Functions;
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

        $keyword = explode(':', $this->tokens->curent()->content);
        $name = $keyword[0];
        $type = Type::fromString($keyword[1] ?? null);
        return new KeywordNode($name, $type);
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

        return new ($this->getFunction($name->content))($name->content, $children);
    }

    public function getFunction(string $name): string
    {
        return match ($name) {
            '$', 'define', 'let' => Functions\Definition::class,
            '@', 'type' => Functions\TypeDefinition::class,
            '\\', 'lambda', 'λ' => Functions\Lambda::class,
            '+', '-', '/', '*', '%' => Functions\Math::class,
            default => Functions\UserFunction::class
        };
    }
}
