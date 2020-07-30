<?php
/**
 * Generated by Haxe 4.1.3
 */

namespace tink\_Stringly;

use \php\_Boot\HxAnon;
use \php\Boot;
use \tink\core\TypedError;
use \tink\core\Outcome;
use \tink\core\OutcomeTools;

final class Stringly_Impl_ {
	/**
	 * @var \EReg
	 */
	static public $SUPPORTED_DATE_REGEX;

	/**
	 * @param string $this
	 * 
	 * @return bool
	 */
	public static function isFloat ($this1) {
		return Stringly_Impl_::isNumber(\trim($this1), true);
	}

	/**
	 * @param string $this
	 * 
	 * @return bool
	 */
	public static function isInt ($this1) {
		return Stringly_Impl_::isNumber(\trim($this1), false);
	}

	/**
	 * @param string $s
	 * @param bool $allowFloat
	 * 
	 * @return bool
	 */
	public static function isNumber ($s, $allowFloat) {
		if (mb_strlen($s) === 0) {
			return false;
		}
		$pos = 0;
		$max = mb_strlen($s);
		if ((0 < $max) && (\StringTools::fastCodeAt($s, 0) === 45)) {
			$pos = 1;
		}
		if (!$allowFloat) {
			if (($pos < $max) && (\StringTools::fastCodeAt($s, $pos) === 48) && ($pos++ > -1)) {
				if (($pos < $max) && (\StringTools::fastCodeAt($s, $pos) === 120)) {
					++$pos;
				}
			}
		}
		while (($pos < $max) && ((\StringTools::fastCodeAt($s, $pos) ^ 48) < 10)) {
			++$pos;
		}
		if ($allowFloat && ($pos < $max)) {
			if (($pos < $max) && (\StringTools::fastCodeAt($s, $pos) === 46) && ($pos++ > -1)) {
				while (($pos < $max) && ((\StringTools::fastCodeAt($s, $pos) ^ 48) < 10)) {
					++$pos;
				}
			}
			if ((($pos < $max) && (\StringTools::fastCodeAt($s, $pos) === 101) && ($pos++ > -1)) || (($pos < $max) && (\StringTools::fastCodeAt($s, $pos) === 69) && ($pos++ > -1))) {
				if (!(($pos < $max) && (\StringTools::fastCodeAt($s, $pos) === 43) && ($pos++ > -1))) {
					if (($pos < $max) && (\StringTools::fastCodeAt($s, $pos) === 45)) {
						++$pos;
					}
				}
				while (($pos < $max) && ((\StringTools::fastCodeAt($s, $pos) ^ 48) < 10)) {
					++$pos;
				}
			}
		}
		return $pos === $max;
	}

	/**
	 * @param bool $b
	 * 
	 * @return string
	 */
	public static function ofBool ($b) {
		if ($b) {
			return "true";
		} else {
			return "false";
		}
	}

	/**
	 * @param \Date $d
	 * 
	 * @return string
	 */
	public static function ofDate ($d) {
		return \Std::string($d->getTime());
	}

	/**
	 * @param float $f
	 * 
	 * @return string
	 */
	public static function ofFloat ($f) {
		return \Std::string($f);
	}

	/**
	 * @param int $i
	 * 
	 * @return string
	 */
	public static function ofInt ($i) {
		return \Std::string($i);
	}

	/**
	 * @param string $this
	 * @param \Closure $f
	 * 
	 * @return Outcome
	 */
	public static function parse ($this1, $f) {
		$_g = $f;
		$a1 = $this1;
		return TypedError::catchExceptions(function () use (&$_g, &$a1) {
			return $_g($a1);
		}, null, new HxAnon([
			"fileName" => "tink/Stringly.hx",
			"lineNumber" => 163,
			"className" => "tink._Stringly.Stringly_Impl_",
			"methodName" => "parse",
		]));
	}

	/**
	 * @param string $this
	 * 
	 * @return Outcome
	 */
	public static function parseDate ($this1) {
		$_g = Stringly_Impl_::parseFloat($this1);
		$__hx__switch = ($_g->index);
		if ($__hx__switch === 0) {
			return Outcome::Success(\Date::fromTime($_g->params[0]));
		} else if ($__hx__switch === 1) {
			if (!Stringly_Impl_::$SUPPORTED_DATE_REGEX->match($this1)) {
				return Outcome::Failure(new TypedError(422, "" . ($this1??'null') . " is not a valid date", new HxAnon([
					"fileName" => "tink/Stringly.hx",
					"lineNumber" => 100,
					"className" => "tink._Stringly.Stringly_Impl_",
					"methodName" => "parseDate",
				])));
			}
			$s = \StringTools::replace($this1, "Z", "+00:00");
			$d = \DateTime::createFromFormat((Stringly_Impl_::$SUPPORTED_DATE_REGEX->matched(2) === null ? "Y-m-d\\TH:i:sP" : "Y-m-d\\TH:i:s.uP"), $s, new \DateTimeZone("UTC"));
			if (!$d) {
				return Outcome::Failure(new TypedError(422, "" . ($this1??'null') . " is not a valid date", new HxAnon([
					"fileName" => "tink/Stringly.hx",
					"lineNumber" => 120,
					"className" => "tink._Stringly.Stringly_Impl_",
					"methodName" => "parseDate",
				])));
			}
			return Outcome::Success(\Date::fromTime($d->getTimestamp() * 1000));
		}
	}

	/**
	 * @param string $this
	 * 
	 * @return Outcome
	 */
	public static function parseFloat ($this1) {
		$_g = \trim($this1);
		if (Stringly_Impl_::isNumber($_g, true)) {
			return Outcome::Success(\Std::parseFloat($_g));
		} else {
			return Outcome::Failure(new TypedError(422, "" . ($_g??'null') . " (encoded as " . ($this1??'null') . ") is not a valid float", new HxAnon([
				"fileName" => "tink/Stringly.hx",
				"lineNumber" => 64,
				"className" => "tink._Stringly.Stringly_Impl_",
				"methodName" => "parseFloat",
			])));
		}
	}

	/**
	 * @param string $this
	 * 
	 * @return Outcome
	 */
	public static function parseInt ($this1) {
		$_g = \trim($this1);
		if (Stringly_Impl_::isNumber($_g, false)) {
			return Outcome::Success(\Std::parseInt($_g));
		} else {
			return Outcome::Failure(new TypedError(422, "" . ($_g??'null') . " (encoded as " . ($this1??'null') . ") is not a valid integer", new HxAnon([
				"fileName" => "tink/Stringly.hx",
				"lineNumber" => 79,
				"className" => "tink._Stringly.Stringly_Impl_",
				"methodName" => "parseInt",
			])));
		}
	}

	/**
	 * @param string $this
	 * 
	 * @return bool
	 */
	public static function toBool ($this1) {
		if ($this1 !== null) {
			$__hx__switch = (\mb_strtolower(\trim($this1)));
			if ($__hx__switch === "0" || $__hx__switch === "false" || $__hx__switch === "no") {
				return false;
			} else {
				return true;
			}
		} else {
			return false;
		}
	}

	/**
	 * @param string $this
	 * 
	 * @return \Date
	 */
	public static function toDate ($this1) {
		return OutcomeTools::sure(Stringly_Impl_::parseDate($this1));
	}

	/**
	 * @param string $this
	 * 
	 * @return float
	 */
	public static function toFloat ($this1) {
		return OutcomeTools::sure(Stringly_Impl_::parseFloat($this1));
	}

	/**
	 * @param string $this
	 * 
	 * @return int
	 */
	public static function toInt ($this1) {
		return OutcomeTools::sure(Stringly_Impl_::parseInt($this1));
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


		self::$SUPPORTED_DATE_REGEX = new \EReg("^(\\d{4}-\\d{2}-\\d{2}T\\d{2}:\\d{2}:\\d{2})(\\.\\d{3})?(Z|[\\+-]\\d{2}:\\d{2})\$", "");
	}
}

Boot::registerClass(Stringly_Impl_::class, 'tink._Stringly.Stringly_Impl_');
Stringly_Impl_::__hx__init();
