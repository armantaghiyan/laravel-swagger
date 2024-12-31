<?php


return [


	/*
	|--------------------------------------------------------------------------
	| Laravel Swagger Domain
	|--------------------------------------------------------------------------
	|
	| This is the subdomain where laravel swagger will be accessible from. If the
	| setting is null, laravel swagger will reside under the same domain as the
	| application. Otherwise, this value will be used as the subdomain.
	|
	*/

	'domain' => env('SWAGGER_DOMAIN'),

	/*
	|--------------------------------------------------------------------------
	| Laravel Swagger Path
	|--------------------------------------------------------------------------
	|
	| This is the URI path where laravel swagger will be accessible from. Feel
	| free to change this path to anything you like. Note that the URI will not
	| affect the paths of its internal API that aren't exposed to users.
	|
	*/

	'path' => env('SWAGGER_PATH', 'swagger'),
];