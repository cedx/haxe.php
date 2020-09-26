<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace haxe\macro;

use \php\Boot;
use \php\_Boot\HxEnum;

/**
 * Represents typed constant.
 */
class TConstant extends HxEnum {
	/**
	 * A `Bool` literal.
	 * 
	 * @param bool $b
	 * 
	 * @return TConstant
	 */
	static public function TBool ($b) {
		return new TConstant('TBool', 3, [$b]);
	}

	/**
	 * A `Float` literal, represented as String to avoid precision loss.
	 * 
	 * @param string $s
	 * 
	 * @return TConstant
	 */
	static public function TFloat ($s) {
		return new TConstant('TFloat', 1, [$s]);
	}

	/**
	 * An `Int` literal.
	 * 
	 * @param int $i
	 * 
	 * @return TConstant
	 */
	static public function TInt ($i) {
		return new TConstant('TInt', 0, [$i]);
	}

	/**
	 * The constant `null`.
	 * 
	 * @return TConstant
	 */
	static public function TNull () {
		static $inst = null;
		if (!$inst) $inst = new TConstant('TNull', 4, []);
		return $inst;
	}

	/**
	 * A `String` literal.
	 * 
	 * @param string $s
	 * 
	 * @return TConstant
	 */
	static public function TString ($s) {
		return new TConstant('TString', 2, [$s]);
	}

	/**
	 * The constant `super`.
	 * 
	 * @return TConstant
	 */
	static public function TSuper () {
		static $inst = null;
		if (!$inst) $inst = new TConstant('TSuper', 6, []);
		return $inst;
	}

	/**
	 * The constant `this`.
	 * 
	 * @return TConstant
	 */
	static public function TThis () {
		static $inst = null;
		if (!$inst) $inst = new TConstant('TThis', 5, []);
		return $inst;
	}

	/**
	 * Returns array of (constructorIndex => constructorName)
	 *
	 * @return string[]
	 */
	static public function __hx__list () {
		return [
			3 => 'TBool',
			1 => 'TFloat',
			0 => 'TInt',
			4 => 'TNull',
			2 => 'TString',
			6 => 'TSuper',
			5 => 'TThis',
		];
	}

	/**
	 * Returns array of (constructorName => parametersCount)
	 *
	 * @return int[]
	 */
	static public function __hx__paramsCount () {
		return [
			'TBool' => 1,
			'TFloat' => 1,
			'TInt' => 1,
			'TNull' => 0,
			'TString' => 1,
			'TSuper' => 0,
			'TThis' => 0,
		];
	}
}

Boot::registerClass(TConstant::class, 'haxe.macro.TConstant');
