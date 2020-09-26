<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace tink\semver\_Constraint;

use \php\_Boot\HxAnon;
use \php\Boot;
use \tink\semver\Parser;
use \tink\core\TypedError;
use \tink\core\Outcome;
use \tink\semver\_Version\Version_Impl_;
use \tink\semver\RangeTools;
use \tink\core\OutcomeTools;
use \tink\semver\_Version\Data;
use \tink\parse\_StringSlice\StringSlice_Impl_;
use \tink\semver\Bound;
use \haxe\iterators\ArrayIterator;

final class Constraint_Impl_ {
	/**
	 * @var \Array_hx
	 */
	static public $WILDCARD = null;

	/**
	 * @param \Array_hx $v
	 * 
	 * @return \Array_hx
	 */
	public static function _new ($v) {
		return $v;
	}

	/**
	 * @param \Array_hx $a
	 * @param \Array_hx $b
	 * 
	 * @return \Array_hx
	 */
	public static function and ($a, $b) {
		if ($a === null) {
			return $b;
		} else if ($b === null) {
			return $a;
		} else {
			$ret = new \Array_hx();
			$_g_current = 0;
			$_g_array = $a;
			while ($_g_current < $_g_array->length) {
				$res = ($_g_array->arr[$_g_current++] ?? null);
				$_g1_current = 0;
				$_g1_array = $b;
				while ($_g1_current < $_g1_array->length) {
					$_g = RangeTools::intersect($res, ($_g1_array->arr[$_g1_current++] ?? null));
					$__hx__switch = ($_g->index);
					if ($__hx__switch === 0) {
						$res = $_g->params[0];
					} else if ($__hx__switch === 1) {
						$res = null;
						break;
					}
				};
				if ($res !== null) {
					$ret->arr[$ret->length++] = $res;
				}
			}
			return Constraint_Impl_::create($ret);
		}
	}

	/**
	 * @param \Array_hx $this
	 * 
	 * @return \Array_hx
	 */
	public static function array ($this1) {
		return $this1;
	}

	/**
	 * @param \Array_hx $ranges
	 * 
	 * @return \Array_hx
	 */
	public static function create ($ranges) {
		$merged = new \Array_hx();
		$_g = 0;
		while ($_g < $ranges->length) {
			$_g1 = RangeTools::nonEmpty(($ranges->arr[$_g++] ?? null));
			$__hx__switch = ($_g1->index);
			if ($__hx__switch === 0) {
				$nu = $_g1->params[0];
				$next = new \Array_hx();
				$_g2 = 0;
				while ($_g2 < $merged->length) {
					$old = ($merged->arr[$_g2] ?? null);
					++$_g2;
					$_g3 = RangeTools::merge($old, $nu);
					$__hx__switch = ($_g3->index);
					if ($__hx__switch === 0) {
						$nu = $_g3->params[0];
					} else if ($__hx__switch === 1) {
						$next->arr[$next->length++] = $old;
					}
				}
				$next->arr[$next->length++] = $nu;
				$merged = $next;
			} else if ($__hx__switch === 1) {
			}
		}
		return $merged;
	}

	/**
	 * @param Data $version
	 * 
	 * @return \Array_hx
	 */
	public static function exact ($version) {
		return \Array_hx::wrap([new HxAnon([
			"min" => Bound::Inclusive($version),
			"max" => Bound::Inclusive($version),
		])]);
	}

	/**
	 * @param object $r
	 * 
	 * @return \Array_hx
	 */
	public static function fromRange ($r) {
		return Constraint_Impl_::create(\Array_hx::wrap([$r]));
	}

	/**
	 * @param string $v
	 * 
	 * @return \Array_hx
	 */
	public static function fromString ($v) {
		return OutcomeTools::sure(Constraint_Impl_::parse($v));
	}

	/**
	 * @param \Array_hx $this
	 * 
	 * @return bool
	 */
	public static function get_isSatisfiable ($this1) {
		if ($this1 !== null) {
			return $this1->length > 0;
		} else {
			return true;
		}
	}

	/**
	 * @param \Array_hx $this
	 * 
	 * @return bool
	 */
	public static function get_isWildcard ($this1) {
		return $this1 === null;
	}

	/**
	 * @param \Array_hx $this
	 * 
	 * @return ArrayIterator
	 */
	public static function iterator ($this1) {
		return new ArrayIterator($this1);
	}

	/**
	 * @param \Array_hx $this
	 * @param Data $v
	 * 
	 * @return bool
	 */
	public static function matches ($this1, $v) {
		if ($this1 === null) {
			return true;
		} else {
			$_g = 0;
			while ($_g < $this1->length) {
				if (RangeTools::contains(($this1->arr[$_g++] ?? null), $v)) {
					return true;
				}
			}
			return false;
		}
	}

	/**
	 * @param Data $v
	 * 
	 * @return \Array_hx
	 */
	public static function ofVersion ($v) {
		$_g = $v->preview;
		$_g1 = $v->major;
		if ($_g === null) {
			if ($_g1 === 0) {
				return Constraint_Impl_::exact($v);
			} else {
				return Version_Impl_::range($v, Version_Impl_::nextMajor($v));
			}
		} else {
			if ($_g === "alpha" || $_g === "beta" || $_g === "rc") {
				return Constraint_Impl_::exact($v);
			} else {
				if ($_g1 === 0) {
					return Constraint_Impl_::exact($v);
				} else {
					return Version_Impl_::range($v, Version_Impl_::nextMajor($v));
				}
			}
		}
	}

	/**
	 * @param \Array_hx $a
	 * @param \Array_hx $b
	 * 
	 * @return \Array_hx
	 */
	public static function or ($a, $b) {
		if ($a === null) {
			return null;
		} else if ($b === null) {
			return null;
		} else {
			return Constraint_Impl_::create($a->concat($b));
		}
	}

	/**
	 * @param string $s
	 * 
	 * @return Outcome
	 */
	public static function parse ($s) {
		if ($s === null) {
			return Outcome::Success(Constraint_Impl_::$WILDCARD);
		} else if ($s === "") {
			return Outcome::Success(Constraint_Impl_::$WILDCARD);
		} else {
			return TypedError::catchExceptions(Boot::getInstanceClosure(new Parser(StringSlice_Impl_::ofString($s)), 'parseConstraint'), null, new HxAnon([
				"fileName" => "tink/semver/Constraint.hx",
				"lineNumber" => 23,
				"className" => "tink.semver._Constraint.Constraint_Impl_",
				"methodName" => "parse",
			]));
		}
	}

	/**
	 * @param Data $min
	 * @param Data $max
	 * 
	 * @return \Array_hx
	 */
	public static function range ($min, $max) {
		$o = RangeTools::nonEmpty(new HxAnon([
			"min" => Bound::Inclusive($min),
			"max" => Bound::Exlusive($max),
		]));
		return ($o->index === 0 ? \Array_hx::wrap([$o->params[0]]) : new \Array_hx());
	}

	/**
	 * @param \Array_hx $this
	 * 
	 * @return string
	 */
	public static function toString ($this1) {
		if ($this1 === null) {
			return "*";
		} else if ($this1->length === 0) {
			return "<0.0.0";
		} else {
			$_g = new \Array_hx();
			$_g1 = 0;
			while ($_g1 < $this1->length) {
				$x = RangeTools::toString(($this1->arr[$_g1++] ?? null));
				$_g->arr[$_g->length++] = $x;
			}
			return $_g->join(" || ");
		}
	}
}

Boot::registerClass(Constraint_Impl_::class, 'tink.semver._Constraint.Constraint_Impl_');
Boot::registerGetters('tink\\semver\\_Constraint\\Constraint_Impl_', [
	'isSatisfiable' => true,
	'isWildcard' => true
]);