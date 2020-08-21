<?php
/**
 * Generated by Haxe 4.1.3
 */

namespace tink\semver;

use \php\Boot;
use \tink\semver\_Version\Data;
use \php\_Boot\HxEnum;

class Bound extends HxEnum {
	/**
	 * @param Data $limit
	 * 
	 * @return Bound
	 */
	static public function Exlusive ($limit) {
		return new Bound('Exlusive', 1, [$limit]);
	}

	/**
	 * @param Data $limit
	 * 
	 * @return Bound
	 */
	static public function Inclusive ($limit) {
		return new Bound('Inclusive', 2, [$limit]);
	}

	/**
	 * @return Bound
	 */
	static public function Unbounded () {
		static $inst = null;
		if (!$inst) $inst = new Bound('Unbounded', 0, []);
		return $inst;
	}

	/**
	 * Returns array of (constructorIndex => constructorName)
	 *
	 * @return string[]
	 */
	static public function __hx__list () {
		return [
			1 => 'Exlusive',
			2 => 'Inclusive',
			0 => 'Unbounded',
		];
	}

	/**
	 * Returns array of (constructorName => parametersCount)
	 *
	 * @return int[]
	 */
	static public function __hx__paramsCount () {
		return [
			'Exlusive' => 1,
			'Inclusive' => 1,
			'Unbounded' => 0,
		];
	}
}

Boot::registerClass(Bound::class, 'tink.semver.Bound');
