<?php
/**
 * Generated by Haxe 4.1.2
 */

namespace haxe\macro;

use \php\Boot;
use \php\_Boot\HxEnum;

/**
 * Represents an access modifier.
 * @see https://haxe.org/manual/class-field-access-modifier.html
 */
class Access extends HxEnum {
	/**
	 * Dynamic (re-)bindable access modifier.
	 * @see https://haxe.org/manual/class-field-dynamic.html
	 * 
	 * @return Access
	 */
	static public function ADynamic () {
		static $inst = null;
		if (!$inst) $inst = new Access('ADynamic', 4, []);
		return $inst;
	}

	/**
	 * Extern access modifier.
	 * 
	 * @return Access
	 */
	static public function AExtern () {
		static $inst = null;
		if (!$inst) $inst = new Access('AExtern', 8, []);
		return $inst;
	}

	/**
	 * Final access modifier. For functions, they can not be overridden. For
	 * variables, it means they can be assigned to only once.
	 * 
	 * @return Access
	 */
	static public function AFinal () {
		static $inst = null;
		if (!$inst) $inst = new Access('AFinal', 7, []);
		return $inst;
	}

	/**
	 * Inline access modifier. Allows expressions to be directly inserted in
	 * place of calls to them.
	 * @see https://haxe.org/manual/class-field-inline.html
	 * 
	 * @return Access
	 */
	static public function AInline () {
		static $inst = null;
		if (!$inst) $inst = new Access('AInline', 5, []);
		return $inst;
	}

	/**
	 * Macro access modifier. Allows expression macro functions. These are
	 * normal functions which are executed as soon as they are typed.
	 * 
	 * @return Access
	 */
	static public function AMacro () {
		static $inst = null;
		if (!$inst) $inst = new Access('AMacro', 6, []);
		return $inst;
	}

	/**
	 * Override access modifier.
	 * @see https://haxe.org/manual/class-field-override.html
	 * 
	 * @return Access
	 */
	static public function AOverride () {
		static $inst = null;
		if (!$inst) $inst = new Access('AOverride', 3, []);
		return $inst;
	}

	/**
	 * Private access modifier, grants access to class and its sub-classes
	 * only.
	 * @see https://haxe.org/manual/class-field-visibility.html
	 * 
	 * @return Access
	 */
	static public function APrivate () {
		static $inst = null;
		if (!$inst) $inst = new Access('APrivate', 1, []);
		return $inst;
	}

	/**
	 * Public access modifier, grants access from anywhere.
	 * @see https://haxe.org/manual/class-field-visibility.html
	 * 
	 * @return Access
	 */
	static public function APublic () {
		static $inst = null;
		if (!$inst) $inst = new Access('APublic', 0, []);
		return $inst;
	}

	/**
	 * Static access modifier.
	 * 
	 * @return Access
	 */
	static public function AStatic () {
		static $inst = null;
		if (!$inst) $inst = new Access('AStatic', 2, []);
		return $inst;
	}

	/**
	 * Returns array of (constructorIndex => constructorName)
	 *
	 * @return string[]
	 */
	static public function __hx__list () {
		return [
			4 => 'ADynamic',
			8 => 'AExtern',
			7 => 'AFinal',
			5 => 'AInline',
			6 => 'AMacro',
			3 => 'AOverride',
			1 => 'APrivate',
			0 => 'APublic',
			2 => 'AStatic',
		];
	}

	/**
	 * Returns array of (constructorName => parametersCount)
	 *
	 * @return int[]
	 */
	static public function __hx__paramsCount () {
		return [
			'ADynamic' => 0,
			'AExtern' => 0,
			'AFinal' => 0,
			'AInline' => 0,
			'AMacro' => 0,
			'AOverride' => 0,
			'APrivate' => 0,
			'APublic' => 0,
			'AStatic' => 0,
		];
	}
}

Boot::registerClass(Access::class, 'haxe.macro.Access');
