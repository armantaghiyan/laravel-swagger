<?php

namespace Arman\LaravelSwagger\Http\Controllers;

use Arman\LaravelSwagger\Export\SwaggerExport;
use Illuminate\Contracts\View\View;

class SwaggerController {

	public function index(): View {
		$swagger = (new SwaggerExport())->toArray();

		return view('swagger::layout', compact('swagger'));
	}
}