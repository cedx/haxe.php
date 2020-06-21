<?php
/**
 * Generated by Haxe 4.1.2
 */

namespace tink\core\_Lazy;

use \php\Boot;

class LazyConst implements LazyObject {
	/**
	 * @var mixed
	 */
	public $value;

	/**
	 * @param mixed $value
	 * 
	 * @return void
	 */
	public function __construct ($value) {
		$this->value = $value;
	}

	/**
	 * @param \Closure $f
	 * 
	 * @return LazyObject
	 */
	public function flatMap ($f) {
		$_gthis = $this;
		return new LazyFunc(function () use (&$f, &$_gthis) {
			return $f($_gthis->value)->get();
		});
	}

	/**
	 * @return mixed
	 */
	public function get () {
		return $this->value;
	}

	/**
	 * @param \Closure $f
	 * 
	 * @return LazyObject
	 */
	public function map ($f) {
		$_gthis = $this;
		return new LazyFunc(function () use (&$f, &$_gthis) {
			return $f($_gthis->value);
		});
	}
}

Boot::registerClass(LazyConst::class, 'tink.core._Lazy.LazyConst');
