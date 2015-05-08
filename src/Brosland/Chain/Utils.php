<?php

namespace Brosland\Chain;

class Utils extends \Nette\Object
{

	/**
	 * @param array $required
	 * @param array $subject
	 */
	public static function checkRequiredFields(array $required, array $subject)
	{
		foreach ($required as $key => $value)
		{
			if (is_array($value))
			{
				if (!isset($subject[$key]))
				{
					throw new \Nette\InvalidArgumentException("Missing field '{$key}'.");
				}
				else if (!is_array($subject[$key]))
				{
					throw new \Nette\InvalidArgumentException("Field '{$key}' have to be an array.");
				}

				self::checkRequiredFields($required[$key], $subject[$key]);
			}
			else if (!array_key_exists($value, $subject))
			{
				throw new \Nette\InvalidArgumentException("Missing field '{$value}'.");
			}
		}
	}

	/**
	 * @param string $x In Satoshi.
	 * @param string $y In Satoshi.
	 * @return string
	 */
	public static function add($x, $y)
	{
		return bcadd($x, $y);
	}

	/**
	 * @param string $x In Satoshi.
	 * @param string $y In Satoshi.
	 * @return string
	 */
	public static function sub($x, $y)
	{
		return bcsub($x, $y);
	}

	/**
	 * @param string $x In Satoshi.
	 * @param string $y In Satoshi.
	 * @return string
	 */
	public static function mul($x, $y)
	{
		return bcmul($x, $y);
	}

	/**
	 * @param string $x In Satoshi.
	 * @param string $y In Satoshi.
	 * @param int $precision
	 * @return string
	 */
	public static function div($x, $y, $precision = 8)
	{
		return bcdiv($x, $y, $precision);
	}

	/**
	 * @param string $x In Satoshi.
	 * @param string $y In Satoshi.
	 * @return int
	 */
	public static function compare($x, $y)
	{
		return bccomp($x, $y, 8);
	}
}