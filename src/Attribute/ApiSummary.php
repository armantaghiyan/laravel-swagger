<?php

namespace Arman\LaravelSwagger\Attribute;

use Attribute;

#[Attribute]
class ApiSummary {

	public function __construct(
		public string $summary,
	) {
	}
}