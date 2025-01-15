<?php

namespace Arman\LaravelSwagger\Attribute;

use Attribute;

#[Attribute]
class Section {

	public function __construct(
		public string $name
	) {
	}
}
