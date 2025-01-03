<?php


return [
	/*
	|--------------------------------------------------------------------------
	| Laravel Swagger Domain
	|--------------------------------------------------------------------------
	|
	| Subdomain where swagger will be accessible. If null, it uses the same
	| domain as the application.
	|
	*/
	'domain' => env('SWAGGER_DOMAIN'),

	/*
	|--------------------------------------------------------------------------
	| Laravel Swagger Prefix Url
	|--------------------------------------------------------------------------
	|
	| URI path prefix for swagger access. Customizable but won't affect
	| internal API URLs.
	|
	*/
	'prefix' => env('SWAGGER_PREFIX', 'swagger'),

	/*
	|--------------------------------------------------------------------------
	| Laravel Swagger Save Path
	|--------------------------------------------------------------------------
	|
	| Directory path where swagger documentation files will be saved.
	|
	*/
	'save_path' => env('SWAGGER_SAVE_PATH', storage_path('docs')),

	/*
	|--------------------------------------------------------------------------
	| Paths to Watch
	|--------------------------------------------------------------------------
	|
	| List of directories and files to monitor for changes when using swagger:watch
	| command. Changes in these paths will trigger automatic swagger regeneration.
	|
	*/
	'watch' => [
		'app/Http/Controllers',
		'routes',
	],
];