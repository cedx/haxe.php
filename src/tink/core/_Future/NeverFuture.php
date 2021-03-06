<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace tink\core\_Future;

use \php\Boot;
use \tink\core\LinkObject;
use \tink\core\FutureObject;

class NeverFuture implements FutureObject {
	/**
	 * @var NeverFuture
	 */
	static public $inst;

	/**
	 * @return void
	 */
	public function __construct () {
	}

	/**
	 * @return FutureObject
	 */
	public function eager () {
		return NeverFuture::$inst;
	}

	/**
	 * @param \Closure $f
	 * 
	 * @return FutureObject
	 */
	public function flatMap ($f) {
		return NeverFuture::$inst;
	}

	/**
	 * @return FutureObject
	 */
	public function gather () {
		return NeverFuture::$inst;
	}

	/**
	 * @param \Closure $callback
	 * 
	 * @return LinkObject
	 */
	public function handle ($callback) {
		return null;
	}

	/**
	 * @param \Closure $f
	 * 
	 * @return FutureObject
	 */
	public function map ($f) {
		return NeverFuture::$inst;
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


		self::$inst = new NeverFuture();
	}
}

Boot::registerClass(NeverFuture::class, 'tink.core._Future.NeverFuture');
NeverFuture::__hx__init();
