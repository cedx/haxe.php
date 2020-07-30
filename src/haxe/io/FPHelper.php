<?php
/**
 * Generated by Haxe 4.1.3
 */

namespace haxe\io;

use \haxe\_Int64\___Int64;
use \php\Boot;

class FPHelper {
	/**
	 * @var ___Int64
	 */
	static public $i64tmp;
	/**
	 * @var bool
	 */
	static public $isLittleEndian;

	/**
	 * @param float $v
	 * 
	 * @return ___Int64
	 */
	public static function doubleToI64 ($v) {
		$a = \unpack((FPHelper::$isLittleEndian ? "V2" : "N2"), \pack("d", $v));
		$i64 = FPHelper::$i64tmp;
		$i64->low = $a[(FPHelper::$isLittleEndian ? 1 : 2)];
		$i64->high = $a[(FPHelper::$isLittleEndian ? 2 : 1)];
		return $i64;
	}

	/**
	 * @param float $f
	 * 
	 * @return int
	 */
	public static function floatToI32 ($f) {
		return \unpack("l", \pack("f", $f))[1];
	}

	/**
	 * @param int $i
	 * 
	 * @return float
	 */
	public static function i32ToFloat ($i) {
		return \unpack("f", \pack("l", $i))[1];
	}

	/**
	 * @param int $low
	 * @param int $high
	 * 
	 * @return float
	 */
	public static function i64ToDouble ($low, $high) {
		return \unpack("d", \pack("ii", (FPHelper::$isLittleEndian ? $low : $high), (FPHelper::$isLittleEndian ? $high : $low)))[1];
	}

	/**
	 * @internal
	 * @access private
	 */
	static public function __hx__init ()
	{
		static $called = false;
		if ($called) return;
		$called = true;


		self::$isLittleEndian = Boot::equal(\unpack("S", "\x01\x00")[1], 1);
		self::$i64tmp = new ___Int64(0, 0);
	}
}

Boot::registerClass(FPHelper::class, 'haxe.io.FPHelper');
FPHelper::__hx__init();
