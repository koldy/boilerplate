<?php declare(strict_types=1);

use App\Config;
use Koldy\Application;
use Koldy\Response\Json;
use Koldy\Response\Plain;
use Koldy\Response\View;

/**
 * Class IndexController
 *
 * @link https://koldy.net/framework/docs/2.0/routes/default-route.md
 */
class IndexController
{

	/**
	 * @link http://localhost:5000
	 */
	public function getIndex()
	{
		return View::create('base')
			->set('page', 'index')
			->set('version', Config::getVersion())
			->set('documentation_url', 'https://koldy.net/framework/docs/2.0/getting-started.md');
	}

	/**
	 * @return Json
	 * @link http://localhost:5000/json
	 */
	public function getJson()
	{
		return Json::create([
			'success' => true
		]);
	}

	/**
	 * The robots.txt - instead of placing the robots.txt file on your server,
	 * you can serve it from here.
	 *
	 * This will check if your app is in development mode. If it is, then it will
	 * server robots.txt which will say all bots not to index anything, otherwise,
	 * if your app is in production, then it will say: index everything.
	 *
	 * Feel free to adjust this as you wish.
	 *
	 * @return \Koldy\Response\Plain
	 * @link http://localhost:5000/robots.txt
	 */
	public function getRobotsTxt()
	{
		if (!Application::isLive()) {
			return Plain::create("User-agent: *\nDisallow: /");
		} else {
			return Plain::create("User-agent: *\nDisallow: ");
		}
	}

	/**
	 * @throws \App\Exception
	 * @link http://localhost:5000/test-exception
	 */
	public function getTestException()
	{
		throw new \App\Exception('Testing failed request');
	}

	/**
	 * @return Plain
	 * @link http://localhost:5000/test-error
	 */
	public function getTestError()
	{
		\Koldy\Log::error('Test error 1');
		\Koldy\Log::alert('Test alert 2');
		\Koldy\Log::emergency('Test emergency 3');
		return Plain::create('OK');
	}

}
