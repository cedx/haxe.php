<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace tink\parse\_StringSlice;

use \php\Boot;
use \php\_Boot\HxString;

final class StringSlice_Impl_ {
	/**
	 * @var \Array_hx
	 */
	static public $CHARS;
	/**
	 * @var Data
	 */
	static public $EMPTY;

	/**
	 * @param string $string
	 * @param int $start
	 * @param int $end
	 * 
	 * @return Data
	 */
	public static function _new ($string, $start, $end) {
		return new Data($string, ($start === mb_strlen($string) ? $start : ($start < 0 ? ($start % mb_strlen($string)) + mb_strlen($string) : $start % mb_strlen($string))), ($end === mb_strlen($string) ? $end : ($end < 0 ? ($end % mb_strlen($string)) + mb_strlen($string) : $end % mb_strlen($string))));
	}

	/**
	 * @param Data $this
	 * @param int $index
	 * 
	 * @return Data
	 */
	public static function after ($this1, $index) {
		return new Data($this1->string, StringSlice_Impl_::wrap($this1, $index) + $this1->start, $this1->end);
	}

	/**
	 * @param Data $this
	 * @param int $index
	 * 
	 * @return Data
	 */
	public static function before ($this1, $index) {
		return new Data($this1->string, $this1->start, $this1->start + StringSlice_Impl_::clamp($this1, $index));
	}

	/**
	 * @param Data $this
	 * @param int $index
	 * 
	 * @return int
	 */
	public static function clamp ($this1, $index) {
		if ($index < 0) {
			if (-$index > $this1->length) {
				return 0;
			} else {
				return $index + $this1->length;
			}
		} else if ($index > $this1->length) {
			return $this1->length;
		} else {
			return $index;
		}
	}

	/**
	 * @param Data $a
	 * @param Data $b
	 * 
	 * @return bool
	 */
	public static function equals ($a, $b) {
		if ($a->length === $b->length) {
			return StringSlice_Impl_::hasSub($a, $b);
		} else {
			return false;
		}
	}

	/**
	 * @param Data $slice
	 * @param string $string
	 * 
	 * @return bool
	 */
	public static function equalsString ($slice, $string) {
		if (($string === null) || (mb_strlen($string) !== $slice->length)) {
			return false;
		} else {
			return StringSlice_Impl_::isEqual($slice->string, $slice->start, $slice->length, $string, 0, mb_strlen($string));
		}
	}

	/**
	 * @param Data $this
	 * @param int $index
	 * 
	 * @return int
	 */
	public static function fastGet ($this1, $index) {
		return \StringTools::fastCodeAt($this1->string, $index + $this1->start);
	}

	/**
	 * @param Data $this
	 * @param int $index
	 * 
	 * @return int
	 */
	public static function get ($this1, $index) {
		return \StringTools::fastCodeAt($this1->string, StringSlice_Impl_::wrap($this1, $index) + $this1->start);
	}

	/**
	 * @param Data $this
	 * @param Data $other
	 * @param int $at
	 * 
	 * @return bool
	 */
	public static function hasSub ($this1, $other, $at = 0) {
		if ($at === null) {
			$at = 0;
		}
		$at = StringSlice_Impl_::wrap($this1, $at);
		if (($at + $other->length) > $this1->length) {
			return false;
		}
		$b = $other;
		return StringSlice_Impl_::isEqual($this1->string, $this1->start + $at, $other->length, $b->string, $b->start, $b->length);
	}

	/**
	 * @param Data $this
	 * @param Data $end
	 * @param int $pos
	 * 
	 * @return int
	 */
	public static function indexOf ($this1, $end, $pos = 0) {
		if ($pos === null) {
			$pos = 0;
		}
		$pos = StringSlice_Impl_::wrap($this1, $pos);
		$_g = HxString::indexOf($this1->string, $end->toString(), $pos + $this1->start);
		if ($_g === -1) {
			return -1;
		} else {
			return $_g - $this1->start;
		}
	}

	/**
	 * @param string $s1
	 * @param int $p1
	 * @param int $l1
	 * @param string $s2
	 * @param int $p2
	 * @param int $l2
	 * 
	 * @return bool
	 */
	public static function isEqual ($s1, $p1, $l1, $s2, $p2, $l2) {
		if ($l2 !== $l1) {
			return false;
		}
		$_g = 0;
		while ($_g < $l2) {
			$i = $_g++;
			if (\StringTools::fastCodeAt($s1, $p1 + $i) !== \StringTools::fastCodeAt($s2, $p2 + $i)) {
				return false;
			}
		}
		return true;
	}

	/**
	 * @param string $s
	 * 
	 * @return Data
	 */
	public static function ofString ($s) {
		if (($s === null) || ($s === "")) {
			return StringSlice_Impl_::$EMPTY;
		} else if (mb_strlen($s) === 1) {
			$_g = \StringTools::fastCodeAt($s, 0);
			if ($_g < StringSlice_Impl_::$CHARS->length) {
				return (StringSlice_Impl_::$CHARS->arr[$_g] ?? null);
			} else {
				return new Data($s, 0, mb_strlen($s));
			}
		} else {
			return new Data($s, 0, mb_strlen($s));
		}
	}

	/**
	 * @param Data $this
	 * @param \IntIterator $range
	 * 
	 * @return Data
	 */
	public static function slice ($this1, $range) {
		return StringSlice_Impl_::_new($this1->string, StringSlice_Impl_::wrap($this1, $range->min) + $this1->start, StringSlice_Impl_::clamp($this1, $range->max) + $this1->start);
	}

	/**
	 * @param Data $this
	 * @param Data $other
	 * 
	 * @return bool
	 */
	public static function startsWith ($this1, $other) {
		return StringSlice_Impl_::hasSub($this1, $other);
	}

	/**
	 * @param Data $this
	 * 
	 * @return string
	 */
	public static function toString ($this1) {
		return $this1->toString();
	}

	/**
	 * @param Data $this
	 * @param int $index
	 * 
	 * @return int
	 */
	public static function wrap ($this1, $index) {
		if ($index < 0) {
			return $index + $this1->length;
		} else {
			return $index;
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


		$_g = new \Array_hx();
		{
			$_g1 = 0;
			while ($_g1 < 128) {
				$x = new Data(\mb_chr($_g1++), 0, 1);
				$_g->arr[$_g->length++] = $x;
			}
		};
		self::$CHARS = $_g;
		self::$EMPTY = new Data("", 0, 0);
	}
}

Boot::registerClass(StringSlice_Impl_::class, 'tink.parse._StringSlice.StringSlice_Impl_');
StringSlice_Impl_::__hx__init();
