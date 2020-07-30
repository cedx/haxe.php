<?php
/**
 * Generated by Haxe 4.1.3
 */

namespace haxe\macro;

use \php\Boot;
use \php\_Boot\HxEnum;

class StringLiteralKind extends HxEnum {
	/**
	 * @return StringLiteralKind
	 */
	static public function DoubleQuotes () {
		static $inst = null;
		if (!$inst) $inst = new StringLiteralKind('DoubleQuotes', 0, []);
		return $inst;
	}

	/**
	 * @return StringLiteralKind
	 */
	static public function SingleQuotes () {
		static $inst = null;
		if (!$inst) $inst = new StringLiteralKind('SingleQuotes', 1, []);
		return $inst;
	}

	/**
	 * Returns array of (constructorIndex => constructorName)
	 *
	 * @return string[]
	 */
	static public function __hx__list () {
		return [
			0 => 'DoubleQuotes',
			1 => 'SingleQuotes',
		];
	}

	/**
	 * Returns array of (constructorName => parametersCount)
	 *
	 * @return int[]
	 */
	static public function __hx__paramsCount () {
		return [
			'DoubleQuotes' => 0,
			'SingleQuotes' => 0,
		];
	}
}

Boot::registerClass(StringLiteralKind::class, 'haxe.macro.StringLiteralKind');
