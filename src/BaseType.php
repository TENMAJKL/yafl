<?php

namespace Majkel\Yafl;

enum BaseType
{
    case String;
    case Int;
    case Lambda;
    case GenericType;
    case Data;
    case Constructor;
    case Void;
    case Bool;
}
