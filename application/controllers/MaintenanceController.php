<?php declare(strict_types=1);

use Koldy\Response\View;

/**
 * Class MaintenanceController
 *
 * @link https://koldy.net/framework/docs/2.0/routes/default-route.md
 */
class MaintenanceController
{

	/**
	 * @return \Koldy\Response\AbstractResponse
	 * @link http://localhost:5000/maintenance
	 */
	public function getIndex()
	{
		return View::create('maintenance')
			->statusCode(503)
			->setHeader('Retry-After', 300);
	}
}