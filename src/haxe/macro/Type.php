<?php
/**
 * Generated by Haxe 4.1.2
 */

namespace haxe\macro;

use \php\Boot;
use \php\_Boot\HxEnum;

/**
 * Represents a type.
 */
class Type extends HxEnum {
	/**
	 * Represents an abstract type.
	 * @see https://haxe.org/manual/types-abstract.html
	 * 
	 * @param object $t
	 * @param \Array_hx $params
	 * 
	 * @return Type
	 */
	static public function TAbstract ($t, $params) {
		return new Type('TAbstract', 8, [$t, $params]);
	}

	/**
	 * Represents an anonymous structure type.
	 * @see https://haxe.org/manual/types-anonymous-structure.html
	 * 
	 * @param object $a
	 * 
	 * @return Type
	 */
	static public function TAnonymous ($a) {
		return new Type('TAnonymous', 5, [$a]);
	}

	/**
	 * Represents Dynamic.
	 * @see https://haxe.org/manual/types-dynamic.html
	 * 
	 * @param Type $t
	 * 
	 * @return Type
	 */
	static public function TDynamic ($t) {
		return new Type('TDynamic', 6, [$t]);
	}

	/**
	 * Represents an enum instance.
	 * @see https://haxe.org/manual/types-enum-instance.html
	 * 
	 * @param object $t
	 * @param \Array_hx $params
	 * 
	 * @return Type
	 */
	static public function TEnum ($t, $params) {
		return new Type('TEnum', 1, [$t, $params]);
	}

	/**
	 * Represents a function type.
	 * @see https://haxe.org/manual/types-function.html
	 * 
	 * @param \Array_hx $args
	 * @param Type $ret
	 * 
	 * @return Type
	 */
	static public function TFun ($args, $ret) {
		return new Type('TFun', 4, [$args, $ret]);
	}

	/**
	 * Represents a class instance.
	 * @see https://haxe.org/manual/types-class-instance.html
	 * 
	 * @param object $t
	 * @param \Array_hx $params
	 * 
	 * @return Type
	 */
	static public function TInst ($t, $params) {
		return new Type('TInst', 2, [$t, $params]);
	}

	/**
	 * Used internally by the compiler to delay some typing.
	 * 
	 * @param \Closure $f
	 * 
	 * @return Type
	 */
	static public function TLazy ($f) {
		return new Type('TLazy', 7, [$f]);
	}

	/**
	 * Represents a monomorph.
	 * @see https://haxe.org/manual/types-monomorph.html
	 * 
	 * @param object $t
	 * 
	 * @return Type
	 */
	static public function TMono ($t) {
		return new Type('TMono', 0, [$t]);
	}

	/**
	 * Represents a typedef.
	 * @see https://haxe.org/manual/type-system-typedef.html
	 * 
	 * @param object $t
	 * @param \Array_hx $params
	 * 
	 * @return Type
	 */
	static public function TType ($t, $params) {
		return new Type('TType', 3, [$t, $params]);
	}

	/**
	 * Returns array of (constructorIndex => constructorName)
	 *
	 * @return string[]
	 */
	static public function __hx__list () {
		return [
			8 => 'TAbstract',
			5 => 'TAnonymous',
			6 => 'TDynamic',
			1 => 'TEnum',
			4 => 'TFun',
			2 => 'TInst',
			7 => 'TLazy',
			0 => 'TMono',
			3 => 'TType',
		];
	}

	/**
	 * Returns array of (constructorName => parametersCount)
	 *
	 * @return int[]
	 */
	static public function __hx__paramsCount () {
		return [
			'TAbstract' => 2,
			'TAnonymous' => 1,
			'TDynamic' => 1,
			'TEnum' => 2,
			'TFun' => 2,
			'TInst' => 2,
			'TLazy' => 1,
			'TMono' => 1,
			'TType' => 2,
		];
	}
}

Boot::registerClass(Type::class, 'haxe.macro.Type');
