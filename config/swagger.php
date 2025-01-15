<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Laravel Swagger Title
	|--------------------------------------------------------------------------
	|
	| The title of the Swagger documentation. This will be displayed on the
	| Swagger documentation page.
	|
	*/
	'title' => 'Laravel Swagger',

	/*
	|--------------------------------------------------------------------------
	| Laravel Swagger Version
	|--------------------------------------------------------------------------
	|
	| The version of the Swagger documentation. This represents the version of
	| your API and will be displayed in the Swagger docs.
	|
	*/
	'version' => '1.0.0',

	/*
	|--------------------------------------------------------------------------
	| Laravel Swagger Domain
	|--------------------------------------------------------------------------
	|
	| Subdomain where Swagger will be accessible. If null, it uses the same
	| domain as the application.
	|
	*/
	'domain' => env('SWAGGER_DOMAIN'),

	/*
	|--------------------------------------------------------------------------
	| Laravel Swagger Prefix Url
	|--------------------------------------------------------------------------
	|
	| URI path prefix for accessing Swagger. This is customizable but won't
	| affect internal API URLs.
	|
	*/
	'prefix' => env('SWAGGER_PREFIX', 'swagger'),
];
