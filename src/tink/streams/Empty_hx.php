<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace tink\streams;

use \tink\core\_Future\SyncFuture;
use \php\Boot;
use \tink\core\_Lazy\LazyConst;
use \tink\core\FutureObject;

class Empty_hx extends StreamBase {
	/**
	 * @var Empty_hx
	 */
	static public $inst;

	/**
	 * @return StreamObject
	 */
	public static function make () {
		return Empty_hx::$inst;
	}

	/**
	 * @return void
	 */
	public function __construct () {
		parent::__construct();
	}

	/**
	 * @param \Closure $handler
	 * 
	 * @return FutureObject
	 */
	public function forEach ($handler) {
		return new SyncFuture(new LazyConst(Conclusion::Depleted()));
	}

	/**
	 * @return bool
	 */
	public function get_depleted () {
		return true;
	}

	/**
	 * @return FutureObject
	 */
	public function next () {
		return new SyncFuture(new LazyConst(Step::End()));
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


		self::$inst = new Empty_hx();
	}
}

Boot::registerClass(Empty_hx::class, 'tink.streams.Empty');
Empty_hx::__hx__init();
