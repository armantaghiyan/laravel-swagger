<?php

namespace Arman\LaravelSwagger\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Section {

	public function __construct(
		public string $name
	) {
	}
}
