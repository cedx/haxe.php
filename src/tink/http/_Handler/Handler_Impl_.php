<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace tink\http\_Handler;

use \php\Boot;
use \tink\http\SimpleHandler;
use \tink\http\HandlerObject;

final class Handler_Impl_ {
	/**
	 * @param \Closure $f
	 * 
	 * @return HandlerObject
	 */
	public static function ofFunc ($f) {
		return new SimpleHandler($f);
	}
}

Boot::registerClass(Handler_Impl_::class, 'tink.http._Handler.Handler_Impl_');
