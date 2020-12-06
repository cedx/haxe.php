<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace tink\streams\_Stream;

use \php\_Boot\HxAnon;
use \tink\core\_Future\SyncFuture;
use \php\Boot;
use \tink\core\_Lazy\LazyConst;

final class Regrouper_Impl_ {
	/**
	 * @param \Closure $f
	 * 
	 * @return object
	 */
	public static function ofFunc ($f) {
		return new HxAnon(["apply" => $f]);
	}

	/**
	 * @param \Closure $f
	 * 
	 * @return object
	 */
	public static function ofFuncSync ($f) {
		return new HxAnon(["apply" => function ($i, $s) use (&$f) {
			return new SyncFuture(new LazyConst($f($i, $s)));
		}]);
	}

	/**
	 * @param \Closure $f
	 * 
	 * @return object
	 */
	public static function ofIgnorance ($f) {
		return new HxAnon(["apply" => function ($i, $_) use (&$f) {
			return $f($i);
		}]);
	}

	/**
	 * @param \Closure $f
	 * 
	 * @return object
	 */
	public static function ofIgnoranceSync ($f) {
		return new HxAnon(["apply" => function ($i, $_) use (&$f) {
			return new SyncFuture(new LazyConst($f($i)));
		}]);
	}
}

Boot::registerClass(Regrouper_Impl_::class, 'tink.streams._Stream.Regrouper_Impl_');
