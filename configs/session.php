<?php declare(strict_types=1);

/**
 * For more info on this config, check:
 *
 * @link http://koldy.net/docs/session#configuration
 */
return [

	/*
	'adapter_class' => '\Koldy\Session\Adapter\Db',
	'options' => [
	  'connection' => 'portal',
	  'table' => 'session'
	],
	*/

	'cookie_life' => 0,
	'cookie_path' => '/',
	'cookie_domain' => '',
	'cookie_secure' => false,
	'session_name' => 'koldy',
	'http_only' => true

];
