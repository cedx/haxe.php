<?php
/**
 * Generated by Haxe 4.1.3
 */

namespace haxe\macro;

use \php\Boot;
use \php\_Boot\HxEnum;

/**
 * Represents a field kind.
 */
class FieldKind extends HxEnum {
	/**
	 * A method
	 * 
	 * @param MethodKind $k
	 * 
	 * @return FieldKind
	 */
	static public function FMethod ($k) {
		return new FieldKind('FMethod', 1, [$k]);
	}

	/**
	 * A variable of property, depending on the `read` and `write` values.
	 * 
	 * @param VarAccess $read
	 * @param VarAccess $write
	 * 
	 * @return FieldKind
	 */
	static public function FVar ($read, $write) {
		return new FieldKind('FVar', 0, [$read, $write]);
	}

	/**
	 * Returns array of (constructorIndex => constructorName)
	 *
	 * @return string[]
	 */
	static public function __hx__list () {
		return [
			1 => 'FMethod',
			0 => 'FVar',
		];
	}

	/**
	 * Returns array of (constructorName => parametersCount)
	 *
	 * @return int[]
	 */
	static public function __hx__paramsCount () {
		return [
			'FMethod' => 1,
			'FVar' => 2,
		];
	}
}

Boot::registerClass(FieldKind::class, 'haxe.macro.FieldKind');
