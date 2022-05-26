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
	],

	'phpmailer' => [
		'enabled' => true,
		'adapter_class' => \KoldyPHPMailer\PHPMailer::class,
		'options' => [
			'host' => 'your.domain.com',
			'port' => 587,
			'username' => 'your.username',
			'password' => 'your.password',
			'type' => 'smtp',
			'adjust' => function ($phpmailer) { // optional
				// you can adjust the PHPMailer's instance here, for example:
				$phpmailer->SMTPDebug = \PHPMailer\PHPMailer\SMTP::DEBUG_SERVER;
			}
		]
	]

];
