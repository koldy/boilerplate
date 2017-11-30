<?php declare(strict_types=1);

namespace Test\App;

use App\Test;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @covers AppTest
 */
final class TestTest extends TestCase
{

	public function testCanBeCreatedFromValidEmailAddress(): void
	{
		$this->assertInstanceOf(Test::class, Test::fromString('user@example.com'));
	}

	public function testCannotBeCreatedFromInvalidEmailAddress(): void
	{
		$this->expectException(InvalidArgumentException::class);

		Test::fromString('invalid');
	}

	public function testCanBeUsedAsString(): void
	{
		$this->assertEquals('user@example.com', Test::fromString('user@example.com'));
	}

}
