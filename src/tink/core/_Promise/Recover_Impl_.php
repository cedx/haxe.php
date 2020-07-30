<?php
/**
 * Generated by Haxe 4.1.3
 */

namespace tink\core\_Promise;

use \tink\core\_Future\SyncFuture;
use \php\Boot;
use \tink\core\_Lazy\LazyConst;

final class Recover_Impl_ {
	/**
	 * @param \Closure $f
	 * 
	 * @return \Closure
	 */
	public static function ofSync ($f) {
		return function ($e) use (&$f) {
			return new SyncFuture(new LazyConst($f($e)));
		};
	}
}

Boot::registerClass(Recover_Impl_::class, 'tink.core._Promise.Recover_Impl_');
