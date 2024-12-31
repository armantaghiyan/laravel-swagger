<?php

namespace Arman\LaravelSwagger\Http\Controllers;

use Illuminate\Contracts\View\View;

class SwaggerController {

	public function index(): View {
		$json = file_get_contents(storage_path('docs/swagger.json'));

		return view('swagger::layout', compact('json'));
	}
}