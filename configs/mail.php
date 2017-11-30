<?php declare(strict_types=1);

/**
 * For more info on this config, check:
 *
 * @link https://koldy.net/framework/docs/2.0/mail.md#configuration
 */
return [

	'file' => [
		'enabled' => true,
		'adapter_class' => '\Koldy\Mail\Adapter\File'
	],

	'simulate' => [
		'enabled' => true,
		'adapter_class' => '\Koldy\Mail\Adapter\Simulate'
	],

	'sendmail' => [
		'enabled' => true,
		'adapter_class' => '\Koldy\Mail\Adapter\Mail'
	]

];
