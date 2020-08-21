<?php
/**
 * Generated by Haxe 4.1.3
 */

namespace tink\semver\_Version;

use \php\Boot;

final class Comparison_Impl_ {

	/**
	 * @param int $a
	 * @param int $b
	 * 
	 * @return int
	 */
	public static function chain ($a, $b) {
		if ($a === 0) {
			return $b;
		} else {
			return $a;
		}
	}

	/**
	 * @param float $f
	 * 
	 * @return int
	 */
	public static function fromFloat ($f) {
		if ($f > 0) {
			return 1;
		} else if ($f < 0) {
			return -1;
		} else {
			return 0;
		}
	}

	/**
	 * @param int $i
	 * 
	 * @return int
	 */
	public static function fromInt ($i) {
		if ($i > 0) {
			return 1;
		} else if ($i < 0) {
			return -1;
		} else {
			return 0;
		}
	}

	/**
	 * @param int $this
	 * 
	 * @return bool
	 */
	public static function toBool ($this1) {
		return (($this1 > 0 ? 1 : ($this1 < 0 ? -1 : 0))) === 0;
	}
}

Boot::registerClass(Comparison_Impl_::class, 'tink.semver._Version.Comparison_Impl_');
