<?php

namespace Majkel\Yafl;

use ParseError;

class Lexer
{
    public function lex(string $code): Stream
    {
        $result = [];
        $pos = 0;
        $line = 0;
        $curent = '';
        while ($pos < strlen($code)) {
            $char = $code[$pos];
            switch ($char) {
                case '(': 
                    $result[] = new Token(TokenKind::Open, '(', $line);
                    break;
                case ')':
                    if ($curent !== '') { 
                        if (is_numeric($curent)) {
                            $kind = TokenKind::Number;
                        } else {
                            $kind = TokenKind::Keyword;
                        }

                        $result[] = new Token($kind, $curent, $line);
                        $curent = '';
                    }
                    $result[] = new Token(TokenKind::Close, ')', $line);
                    break;
                case "\n":
                    $line++;
                case ' ':
                    if ($curent === '') {
                        break;
                    }
                    
                    if (is_numeric($curent)) {
                        $kind = TokenKind::Number;
                    } else {
                        $kind = TokenKind::Keyword;
                    }

                    $result[] = new Token($kind, $curent, $line);
                    $curent = '';
                    break;
                case '#':
                case ';':
                    do {
                        $pos++;
                        $char = $code[$pos];
                    } while ($char != "\n");
                    break;     
                case '"':
                    $pos++;
                    $char = $code[$pos] ?? null;
                    while ($char != '"') {
                        if (is_null($char)) {
                            throw new ParseError('Unclosed string');
                        }
                        $curent .= $char;
                        $pos++;
                        $char = $code[$pos] ?? null;
                    }
                    $result[] = new Token(TokenKind::String, $curent, $line);
                    $curent = '';
                    break;
                default:
                    if (is_numeric($char)) {
                        $curent .= $char; 
                    } else if (is_numeric($curent)) {
                        throw new ParseError('Unexpected char '.$char);
                    } else {
                        $curent .= $char;
                    }
            }

            $pos++;
        }

        return new Stream($result);
    }
}
