<?php declare(strict_types=1);
/**
 * Let's configure environment for PHPUnit! Yeey... let's try to make this simple.
 */

require __DIR__ . '/../vendor/autoload.php';

$project = dirname(__DIR__);

Koldy\Application::useConfig([

	'site_url' => 'http://localhost:5000',

	'assets' => [
		'static' => '/static'
	],

	'paths' => [
		'application' => $project . '/application/',
		'storage' => $project . '/storage/',
		'view' => null,
		'modules' => null,
		'scripts' => null,
		'configs' => "{$project}/configs/"
	],

	'config' => [],

	'env' => Koldy\Application::DEVELOPMENT,
	'live' => false,
	'timezone' => 'UTC',
	'additional_include_path' => [],
	'key' => 'ThisShouldBeYourCustomKeyOf32CHR',

	'routing_class' => '\Koldy\Route\DefaultRoute',
	'routing_options' => [
		'always_restful' => false
	],

	'security' => [
		'openssl_default_method' => 'aes-256-cbc',

		'csrf' => [
			'enabled' => false,
			'parameter_name' => 'csrf',
			'cookie_name' => 'csrf_token',
			'session_key_name' => 'csrf_token'
		]
	],

	'filesystem' => [
		'default_chmod' => 0644
	],

	'log' => []

]);

\Koldy\Application::init();

/**
 * As we continue....... define any FIXTURES below
 */
