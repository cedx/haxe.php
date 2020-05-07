<?php
/**
 * Generated by Haxe 4.0.5
 */

namespace haxe;

use \php\Boot;
use \php\_Boot\HxString;

class SysTools {
	/**
	 * @var \Array_hx
	 * Character codes of the characters that will be escaped by `quoteWinArg(_, true)`.
	 */
	static public $winMetaCharacters;

	/**
	 * Returns a String that can be used as a single command line argument
	 * on Unix.
	 * The input will be quoted, or escaped if necessary.
	 * 
	 * @param string $argument
	 * 
	 * @return string
	 */
	public static function quoteUnixArg ($argument) {
		if ($argument === "") {
			return "''";
		}
		if (!(new \EReg("[^a-zA-Z0-9_@%+=:,./-]", ""))->match($argument)) {
			return $argument;
		}
		return "'" . (\StringTools::replace($argument, "'", "'\"'\"'")??'null') . "'";
	}

	/**
	 * Returns a String that can be used as a single command line argument
	 * on Windows.
	 * The input will be quoted, or escaped if necessary, such that the output
	 * will be parsed as a single argument using the rule specified in
	 * http://msdn.microsoft.com/en-us/library/ms880421
	 * Examples:
	 * ```haxe
	 * quoteWinArg("abc") == "abc";
	 * quoteWinArg("ab c") == '"ab c"';
	 * ```
	 * 
	 * @param string $argument
	 * @param bool $escapeMetaCharacters
	 * 
	 * @return string
	 */
	public static function quoteWinArg ($argument, $escapeMetaCharacters) {
		if (!(new \EReg("^[^ \x09\\\\\"]+\$", ""))->match($argument)) {
			$result = new \StringBuf();
			$needquote = (HxString::indexOf($argument, " ") !== -1) || (HxString::indexOf($argument, "\x09") !== -1) || ($argument === "");
			if ($needquote) {
				$result->add("\"");
			}
			$bs_buf = new \StringBuf();
			$_g = 0;
			$_g1 = mb_strlen($argument);
			while ($_g < $_g1) {
				$i = $_g++;
				$_g2 = HxString::charCodeAt($argument, $i);
				if ($_g2 === null) {
					$c = $_g2;
					if (mb_strlen($bs_buf->b) > 0) {
						$result->add($bs_buf->b);
						$bs_buf = new \StringBuf();
					}
					$result1 = $result;
					$result1->b = ($result1->b??'null') . (mb_chr($c)??'null');

				} else {
					if ($_g2 === 34) {
						$bs = $bs_buf->b;
						$result->add($bs);
						$result->add($bs);
						$bs_buf = new \StringBuf();
						$result->add("\\\"");
					} else if ($_g2 === 92) {
						$bs_buf->add("\\");
					} else {
						$c1 = $_g2;
						if (mb_strlen($bs_buf->b) > 0) {
							$result->add($bs_buf->b);
							$bs_buf = new \StringBuf();
						}
						$result2 = $result;
						$result2->b = ($result2->b??'null') . (mb_chr($c1)??'null');

					}
				}

			}

			$result->add($bs_buf->b);
			if ($needquote) {
				$result->add($bs_buf->b);
				$result->add("\"");
			}
			$argument = $result->b;
		}
		if ($escapeMetaCharacters) {
			$result3 = new \StringBuf();
			$_g3 = 0;
			$_g11 = mb_strlen($argument);
			while ($_g3 < $_g11) {
				$i1 = $_g3++;
				$c2 = HxString::charCodeAt($argument, $i1);
				if (SysTools::$winMetaCharacters->indexOf($c2) >= 0) {
					$result4 = $result3;
					$result4->b = ($result4->b??'null') . (mb_chr(94)??'null');
				}
				$result5 = $result3;
				$result5->b = ($result5->b??'null') . (mb_chr($c2)??'null');
			}

			return $result3->b;
		} else {
			return $argument;
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


		self::$winMetaCharacters = \Array_hx::wrap([
			32,
			40,
			41,
			37,
			33,
			94,
			34,
			60,
			62,
			38,
			124,
			10,
			13,
			44,
			59,
		]);
	}
}

Boot::registerClass(SysTools::class, 'haxe.SysTools');
SysTools::__hx__init();
