<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace tink\core\_Lazy;

use \php\Boot;

final class Lazy_Impl_ {
	/**
	 * @var LazyObject
	 */
	static public $NULL;

	/**
	 * @param LazyObject $this
	 * @param \Closure $f
	 * 
	 * @return LazyObject
	 */
	public static function flatMap ($this1, $f) {
		return $this1->flatMap($f);
	}

	/**
	 * @param LazyObject $this
	 * 
	 * @return mixed
	 */
	public static function get ($this1) {
		return $this1->get();
	}

	/**
	 * @param LazyObject $this
	 * @param \Closure $f
	 * 
	 * @return LazyObject
	 */
	public static function map ($this1, $f) {
		return $this1->map($f);
	}

	/**
	 * @param mixed $c
	 * 
	 * @return LazyObject
	 */
	public static function ofConst ($c) {
		return new LazyConst($c);
	}

	/**
	 * @param \Closure $f
	 * 
	 * @return LazyObject
	 */
	public static function ofFunc ($f) {
		return new LazyFunc($f);
	}

	/**
	 * @internal
	 * @access private
	 */
	static public function __hx__init ()
	{
		static $called = false;
		if ($called) return;
		$called = true;


		self::$NULL = new LazyConst(null);
	}
}

Boot::registerClass(Lazy_Impl_::class, 'tink.core._Lazy.Lazy_Impl_');
Lazy_Impl_::__hx__init();
