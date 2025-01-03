<?php

namespace Arman\LaravelSwagger\Http\Controllers;

use Illuminate\Contracts\View\View;

class SwaggerController {

	public function index(): View {

		return view('swagger::layout');
	}

	public function getSwaggerData() {
		$json = file_get_contents(config('swagger.save_path') . '/swagger.json');

		return json_decode($json, true);
	}
}