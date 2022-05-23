<?php declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$project = dirname(__DIR__);

/**
 * For more info about this config, check
 *
 * @link https://koldy.net/framework/docs/2.0/configuration.md#mandatory-index-php
 */
Koldy\Application::useConfig([

	'site_url' => 'http://localhost:5000',

	'assets' => [ // where are your assets?
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
		'always_restful' => true
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

	'log' => [
		[
			'enabled' => true,
			'adapter_class' => '\Koldy\Log\Adapter\File',
			'options' => [
				'path' => null,
				'mode' => 0777,
				'file_mode' => 0777,
				'log' => ['debug', 'notice', 'info', 'warning', 'error', 'critical', 'alert', 'emergency'],
				'dump' => ['speed', 'memory', 'whitespace']
			]
		],
		[
			'enabled' => (PHP_SAPI == 'cli'),
			'adapter_class' => '\Koldy\Log\Adapter\Out',
			'options' => [
				'log' => ['debug', 'notice', 'info', 'sql', 'warning', 'error', 'critical', 'alert', 'emergency'],
				'dump' => ['speed', 'memory', 'whitespace']
			]
		],
		[
			'enabled' => true,
			'adapter_class' => '\Koldy\Log\Adapter\Other',
			'options' => [
				'log' => ['alert', 'warning', 'error', 'critical', 'emergency'],
				'send_immediately' => PHP_SAPI == 'cli',
				'exec' => function ($message) {
					if (\Koldy\Application::inProduction()) {
						if (is_array($message)) {
							/** @var \Koldy\Log\Message[] $message */
							foreach ($message as $msg) {
								//echo $msg->getMessage();
							}
						} else {
							/** @var $message \Koldy\Log\Message */
							//echo $message->getMessage();
						}
					}
				}
			]
		]
	]
]);

Koldy\Application::run();

// in case you want to "close" the site, simply put:
//Koldy\Application::run('/maintenance');
