<?php

namespace App\Service;

use Ramsey\Uuid\Uuid;

class UniqueGenerator {
	const NUMERIC = '0123456789' ;
	const ALPHA_UPPER = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' ;
	const ALPHA_LOWER = 'abcdefghijklmnopqrstuvwxyz' ;
	const CHAR_SPECIAL = '!@#$&*';
	const NUM_UPPER_LOWER = self::NUMERIC . self::ALPHA_UPPER . self::ALPHA_LOWER ;
	const NUM_UPPER_LOWER_CHAR = self::NUMERIC . self::ALPHA_UPPER . self::ALPHA_LOWER . self::CHAR_SPECIAL ;
	const NUM_LOWER = self::NUMERIC . self::ALPHA_LOWER ;
	const NUM_UPPER = self::NUMERIC . self::ALPHA_UPPER ;
	const NUM_NO_ZERO_ONE = '23456789';
	const UPPER_NO_IOS = 'ABCDEFGHJKLMNPQRTUVWXYZ';
	const LOWER_NO_ILOS = 'abcdefghjkmnpqrtuvwxzy';
	const GOOD_PASSWORD_STRING = self::NUM_NO_ZERO_ONE . self::UPPER_NO_IOS . self::LOWER_NO_ILOS ;

	public function createRandomCode($chars = self::NUM_LOWER)
	{
		srand((double)microtime()*1000000);
		$i = 0;
		$pass = '' ;

		while ($i <= 4) {
			$num = rand() % 33;
			$tmp = substr($chars, $num, 1);
			$pass = $pass . $tmp;
			$i++;
		}

		return strtoupper($pass);
	}

	/**
	 * @param string|null $prefix
	 * @param int $length
	 * @param string $chars
	 *
	 * @return string
	 * @throws \Exception
	 */
	public static function generate(string $prefix = null , int $length = 30, string $chars = self::NUM_UPPER_LOWER): string {

		// Length of character list
		$chars_length = (strlen($chars) - 1);

		// Start our string
		$string = $chars[random_int(0, $chars_length)];

		// Generate random string
		for ($i = 1; $i < $length; $i = strlen($string))
		{
			// Grab a random character from our list
			$r = $chars[random_int(0, $chars_length)];

			// Make sure the same two characters don't appear next to each other
			if ($r != $string[$i - 1]) $string .=  $r;
		}

		// Return the string
		return $prefix . $string ;
	}

	/**
	 * @return string
	 */
	static public function uuid(): string {
		return Uuid::uuid4()->toString() ;
	}


	/**
	 * Generate a password with Uppercase, lowercase, number and special character, one each at least
	 * @param int $length number of characters
	 * @param bool $safe_characters whether to include confusing characters or not
	 *
	 * @return string
	 * @throws \Exception
	 */
	public static function generateStrongPassword( int $length = 8, bool $safe_characters = true ) {
		$special = self::CHAR_SPECIAL;
		if( $safe_characters ) {
			$lower = self::LOWER_NO_ILOS;
			$upper = self::UPPER_NO_IOS;
			$number = self::NUM_NO_ZERO_ONE;
			$characters = self::UPPER_NO_IOS.self::LOWER_NO_ILOS.self::NUM_NO_ZERO_ONE;
		} else {
			$lower = self::ALPHA_LOWER;
			$upper = self::ALPHA_UPPER;
			$number = self::NUMERIC;
			$characters = self::ALPHA_UPPER.self::ALPHA_LOWER.self::NUMERIC;
		}

		$password = ''; //start
		$password .= substr( $upper, random_int( 0, strlen( $upper ) ), 1); //ensure there is at least one UPPERCASE
		$password .= substr( $lower, random_int( 0, strlen( $lower ) ), 1); // ensure LOWER
		$password .= substr( $number, random_int( 0, strlen( $number ) ), 1); // ensure NUM
		$password .= substr( $special, random_int( 0, strlen( $special ) ), 1); //ensure SPEC_CHAR
		for ($i = 0; $i < ($length - 4); $i++) {
			$password .= substr($characters, random_int(0, strlen($characters)), 1); //fill up the rest
		}

		return str_shuffle($password); #randomize
	}
}
