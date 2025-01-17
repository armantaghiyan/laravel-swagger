<?php

namespace Arman\LaravelSwagger\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class ApiSummary {

	public function __construct(
		public string $summary,
	) {
	}
}