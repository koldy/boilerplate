<?php declare(strict_types=1);

use Koldy\Response\Exception\NotFoundException;
use Koldy\Response\Plain;

class IndexController
{

	/**
	 * @return Plain
	 * @link http://localhost:5000/dev
	 * @link http://localhost:5000/dev/index
	 */
	public function getIndex()
	{
		return Plain::create('Dev, OK');
	}

	/**
	 * This is "catch all" method for "/dev" namespace
	 *
	 * @param $name
	 * @param $arguments
	 *
	 * @throws NotFoundException
	 * @link http://localhost:5000/dev/anything-here
	 */
	public function __call($name, $arguments)
	{
		throw new NotFoundException('There is no DEV page here');
	}

}
