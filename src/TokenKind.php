<?php

namespace Majkel\Yafl;

enum TokenKind
{
    case Number;
    case String;
    case Keyword;
    case Open;
    case Close;
}
