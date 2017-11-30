<?php declare(strict_types=1);

/**
 * For more info on this config, check:
 *
 * @link https://koldy.net/framework/docs/2.0/cache.md#configuration
 */
return [

	'default' => 'files',

	'files' => [
		'enabled' => true,
		'adapter_class' => '\Koldy\Cache\Adapter\Files',

		'options' => [
			'path' => null, // if null, then path is [storage]/cache
			'default_duration' => 3600
		]
	],

	'memcached' => [
		'enabled' => true,
		'adapter_class' => '\Koldy\Cache\Adapter\Memcached',

		'options' => [
			'servers' => [ // used in addServers method: http://php.net/manual/en/memcached.addservers.php
				['localhost', 11211]
			],
			'persistent_id' => 'koldy',
			'adapter_options' => []
		]
	],

	'nowhere' => [
		'enabled' => true,
		'adapter_class' => '\Koldy\Cache\Adapter\DevNull'
	],

	'db' => [
		'enabled' => true,
		'adapter_class' => '\Koldy\Cache\Adapter\Db',

		'options' => [
			'connection' => null,
			'table' => 'cache',
			'default_duration' => 3600,
			'clean_old' => (rand(1, 100) % 100 == 0) // the 1:100 probability to clean old items
		]
	]

];
