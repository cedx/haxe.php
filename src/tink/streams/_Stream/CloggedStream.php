<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace tink\streams\_Stream;

use \tink\streams\StreamBase;
use \tink\core\_Future\SyncFuture;
use \php\Boot;
use \tink\streams\Step;
use \tink\core\TypedError;
use \tink\streams\StreamObject;
use \tink\core\_Lazy\LazyConst;
use \tink\streams\Conclusion;
use \tink\core\FutureObject;

class CloggedStream extends StreamBase {
	/**
	 * @var TypedError
	 */
	public $error;
	/**
	 * @var StreamObject
	 */
	public $rest;

	/**
	 * @param StreamObject $rest
	 * @param TypedError $error
	 * 
	 * @return void
	 */
	public function __construct ($rest, $error) {
		parent::__construct();
		$this->rest = $rest;
		$this->error = $error;
	}

	/**
	 * @param \Closure $handler
	 * 
	 * @return FutureObject
	 */
	public function forEach ($handler) {
		return new SyncFuture(new LazyConst(Conclusion::Clogged($this->error, $this->rest)));
	}

	/**
	 * @return FutureObject
	 */
	public function next () {
		return new SyncFuture(new LazyConst(Step::Fail($this->error)));
	}
}

Boot::registerClass(CloggedStream::class, 'tink.streams._Stream.CloggedStream');