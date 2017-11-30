<?php declare(strict_types=1);

namespace App;

use Koldy\Application;

/**
 * Class Config - You should work with this config only
 * @package Api
 */
final class Config
{

	/**
	 * @return \Koldy\Config
	 */
	public static function getConfig(): \Koldy\Config
	{
		return Application::getConfig('versions');
	}

	/**
	 * @return string
	 */
	public static function getVersion(): string
	{
		return static::getConfig()->get('version');
	}

}
