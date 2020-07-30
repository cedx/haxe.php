<?php
/**
 * Generated by Haxe 4.1.3
 */

namespace tink\core;

use \php\Boot;
use \haxe\ds\Option as DsOption;

class TotalTools {
	/**
	 * @param DsOption $a
	 * @param DsOption $b
	 * 
	 * @return bool
	 */
	public static function eq ($a, $b) {
		$__hx__switch = ($a->index);
		if ($__hx__switch === 0) {
			if ($b->index === 0) {
				return Boot::equal($a->params[0], $b->params[0]);
			} else {
				return false;
			}
		} else if ($__hx__switch === 1) {
			if ($b->index === 1) {
				return true;
			} else {
				return false;
			}
		}
	}
}

Boot::registerClass(TotalTools::class, 'tink.core.TotalTools');
