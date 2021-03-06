<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace haxe\macro;

use \php\Boot;
use \php\_Boot\HxEnum;

class DisplayKind extends HxEnum {
	/**
	 * @return DisplayKind
	 */
	static public function DKCall () {
		static $inst = null;
		if (!$inst) $inst = new DisplayKind('DKCall', 0, []);
		return $inst;
	}

	/**
	 * @return DisplayKind
	 */
	static public function DKDot () {
		static $inst = null;
		if (!$inst) $inst = new DisplayKind('DKDot', 1, []);
		return $inst;
	}

	/**
	 * @return DisplayKind
	 */
	static public function DKMarked () {
		static $inst = null;
		if (!$inst) $inst = new DisplayKind('DKMarked', 3, []);
		return $inst;
	}

	/**
	 * @param bool $outermost
	 * 
	 * @return DisplayKind
	 */
	static public function DKPattern ($outermost) {
		return new DisplayKind('DKPattern', 4, [$outermost]);
	}

	/**
	 * @return DisplayKind
	 */
	static public function DKStructure () {
		static $inst = null;
		if (!$inst) $inst = new DisplayKind('DKStructure', 2, []);
		return $inst;
	}

	/**
	 * Returns array of (constructorIndex => constructorName)
	 *
	 * @return string[]
	 */
	static public function __hx__list () {
		return [
			0 => 'DKCall',
			1 => 'DKDot',
			3 => 'DKMarked',
			4 => 'DKPattern',
			2 => 'DKStructure',
		];
	}

	/**
	 * Returns array of (constructorName => parametersCount)
	 *
	 * @return int[]
	 */
	static public function __hx__paramsCount () {
		return [
			'DKCall' => 0,
			'DKDot' => 0,
			'DKMarked' => 0,
			'DKPattern' => 1,
			'DKStructure' => 0,
		];
	}
}

Boot::registerClass(DisplayKind::class, 'haxe.macro.DisplayKind');
