<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace haxe\crypto;

use \haxe\io\_BytesData\Container;
use \php\Boot;
use \haxe\io\Bytes;

class Base64 {
	/**
	 * @var Bytes
	 */
	static public $BYTES;
	/**
	 * @var string
	 */
	static public $CHARS = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
	/**
	 * @var mixed
	 */
	static public $NORMAL_62_63;
	/**
	 * @var mixed
	 */
	static public $URL_62_63;
	/**
	 * @var Bytes
	 */
	static public $URL_BYTES;
	/**
	 * @var string
	 */
	static public $URL_CHARS = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_";

	/**
	 * @param string $str
	 * @param bool $complement
	 * 
	 * @return Bytes
	 */
	public static function decode ($str, $complement = true) {
		if ($complement === null) {
			$complement = true;
		}
		if (!$complement) {
			$__hx__switch = (\strlen($str) % 3);
			if ($__hx__switch === 1) {
				$str = ($str??'null') . "==";
			} else if ($__hx__switch === 2) {
				$str = ($str??'null') . "=";
			} else {
			}
		}
		$s = \base64_decode($str, true);
		$tmp = \strlen($s);
		return new Bytes($tmp, new Container($s));
	}

	/**
	 * @param Bytes $bytes
	 * @param bool $complement
	 * 
	 * @return string
	 */
	public static function encode ($bytes, $complement = true) {
		if ($complement === null) {
			$complement = true;
		}
		$result = \base64_encode($bytes->toString());
		if ($complement) {
			return $result;
		} else {
			return \rtrim($result, "=");
		}
	}

	/**
	 * @param string $str
	 * @param bool $complement
	 * 
	 * @return Bytes
	 */
	public static function urlDecode ($str, $complement = true) {
		if ($complement === null) {
			$complement = true;
		}
		if (!$complement) {
			$__hx__switch = (\strlen($str) % 3);
			if ($__hx__switch === 1) {
				$str = ($str??'null') . "==";
			} else if ($__hx__switch === 2) {
				$str = ($str??'null') . "=";
			} else {
			}
		}
		$s = \base64_decode(\str_replace(Base64::$URL_62_63, Base64::$NORMAL_62_63, $str), true);
		$tmp = \strlen($s);
		return new Bytes($tmp, new Container($s));
	}

	/**
	 * @param Bytes $bytes
	 * @param bool $complement
	 * 
	 * @return string
	 */
	public static function urlEncode ($bytes, $complement = true) {
		if ($complement === null) {
			$complement = true;
		}
		$result = \str_replace(Base64::$NORMAL_62_63, Base64::$URL_62_63, \base64_encode($bytes->toString()));
		if ($complement) {
			return $result;
		} else {
			return \rtrim($result, "=");
		}
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


		$s = Base64::$CHARS;
		$tmp = \strlen($s);
		self::$BYTES = new Bytes($tmp, new Container($s));
		$s = Base64::$URL_CHARS;
		$tmp = \strlen($s);
		self::$URL_BYTES = new Bytes($tmp, new Container($s));
		self::$NORMAL_62_63 = ["+", "/"];
		self::$URL_62_63 = ["-", "_"];
	}
}

Boot::registerClass(Base64::class, 'haxe.crypto.Base64');
Base64::__hx__init();
