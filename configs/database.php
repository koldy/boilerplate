<?php declare(strict_types=1);

/**
 * For more info on this config, check:
 *
 * @link https://koldy.net/framework/docs/2.0/database.md#configuration
 */
return [

	'default' => 'mariadb',
	//'default' => 'website',

	//'koldy_migration' => 'website', // uncomment if you need to set other database where migrations info will be stored

	'website' => [
		'type' => 'postgres',
		'host' => '127.0.0.1',
		'port' => 5432,
		'username' => 'vagrant',
		'password' => 'vagrant',
		'database' => 'vagrant',
		'persistent' => true,
		'schema' => 'public'
	],

	'mariadb' => [
		'type' => 'mysql',
		'host' => '127.0.0.1',
		'port' => 3306,
		'username' => 'vagrant',
		'password' => 'vagrant',
		'database' => 'vagrant',
		'persistent' => true
	]

];
