<?php declare(strict_types=1);

namespace App;

/**
 * Class Test
 * @package App
 *
 * An example class from PHPUnit to test if PHPUnit is working as expected
 * @link https://phpunit.de/getting-started.html
 */
final class Test
{

	private function __construct(private string $email)
	{
		$this->ensureIsValidEmail($email);
	}

	public static function fromString(string $email): self
	{
		return new self($email);
	}

	public function __toString(): string
	{
		return $this->email;
	}

	private function ensureIsValidEmail(string $email): void
	{
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			throw new \InvalidArgumentException(sprintf('"%s" is not a valid email address', $email));
		}
	}
}
