<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace tink\http\_Fetch;

use \php\_Boot\HxAnon;
use \tink\core\_Future\SyncFuture;
use \tink\io\RealSourceTools;
use \php\Boot;
use \tink\core\TypedError;
use \tink\core\Outcome;
use \tink\core\_Lazy\LazyConst;
use \tink\http\Message;
use \tink\core\_Promise\Promise_Impl_;
use \tink\core\FutureObject;

final class FetchResponse_Impl_ {
	/**
	 * @param FutureObject $this
	 * 
	 * @return FutureObject
	 */
	public static function all ($this1) {
		return Promise_Impl_::next($this1, function ($r) {
			return Promise_Impl_::next(RealSourceTools::all($r->body), function ($chunk) use (&$r) {
				if ($r->header->statusCode >= 400) {
					return new SyncFuture(new LazyConst(Outcome::Failure(TypedError::withData($r->header->statusCode, $r->header->reason, $chunk->toString(), new HxAnon([
						"fileName" => "tink/http/Fetch.hx",
						"lineNumber" => 138,
						"className" => "tink.http._Fetch.FetchResponse_Impl_",
						"methodName" => "all",
					])))));
				} else {
					return new SyncFuture(new LazyConst(Outcome::Success(new Message($r->header, $chunk))));
				}
			});
		});
	}
}

Boot::registerClass(FetchResponse_Impl_::class, 'tink.http._Fetch.FetchResponse_Impl_');