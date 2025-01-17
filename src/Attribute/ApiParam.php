<?php

namespace Arman\LaravelSwagger\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class ApiParam {

	public function __construct(
		public string $name,
		public bool   $required = true,
		public string $description = '',
		public ApiParamType $type = ApiParamType::String,
	) {
	}
}