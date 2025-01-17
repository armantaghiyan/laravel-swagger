<?php

namespace Arman\LaravelSwagger\Attribute;

enum ApiParamType: string {
	case Int = 'integer';
	case String = 'string';
	case Double = 'double';
	case Float = 'float';
	case Password = 'password';
	case Boolean = 'boolean';
}
