<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace tink\streams\_IdealStream;

use \tink\core\_Future\SyncFuture;
use \php\Boot;
use \tink\streams\_Stream\Stream_Impl_;
use \tink\streams\StreamObject;
use \tink\streams\Handled;
use \tink\core\_Lazy\LazyConst;
use \tink\streams\_Stream\Handler_Impl_;
use \tink\core\_Promise\Promise_Impl_;
use \tink\core\FutureObject;

final class IdealStream_Impl_ {
	/**
	 * @param StreamObject $this
	 * 
	 * @return FutureObject
	 */
	public static function collect ($this1) {
		$buf = new \Array_hx();
		return $this1->forEach(Handler_Impl_::ofSafe(function ($x) use (&$buf) {
			$buf->arr[$buf->length++] = $x;
			return new SyncFuture(new LazyConst(Handled::Resume()));
		}))->map(function ($c) use (&$buf) {
			return $buf;
		})->gather();
	}

	/**
	 * @param FutureObject $p
	 * 
	 * @return StreamObject
	 */
	public static function promiseOfIdealStream ($p) {
		return Stream_Impl_::promise(Promise_Impl_::ofSpecific($p));
	}

	/**
	 * @param FutureObject $p
	 * 
	 * @return StreamObject
	 */
	public static function promiseOfStreamNoise ($p) {
		return Stream_Impl_::promise($p);
	}
}

Boot::registerClass(IdealStream_Impl_::class, 'tink.streams._IdealStream.IdealStream_Impl_');