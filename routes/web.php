<?php


use Illuminate\Support\Facades\Route;


Route::controller(Arman\LaravelSwagger\Http\Controllers\SwaggerController::class)->group(function () {
	Route::get('/', 'index');
	Route::get('data', 'getSwaggerData');
});
