<?php
/**
 * Generated by Haxe 4.1.3
 */

namespace tink\core\_Future;

use \tink\core\_Lazy\LazyObject;
use \php\Boot;
use \tink\core\LinkObject;
use \tink\core\_Callback\Callback_Impl_;
use \tink\core\FutureObject;

class SyncFuture implements FutureObject {
	/**
	 * @var LazyObject
	 */
	public $value;

	/**
	 * @param LazyObject $value
	 * 
	 * @return void
	 */
	public function __construct ($value) {
		$this->value = $value;
	}

	/**
	 * @return SyncFuture
	 */
	public function eager () {
		return $this;
	}

	/**
	 * @param \Closure $f
	 * 
	 * @return FutureObject
	 */
	public function flatMap ($f) {
		$_gthis = $this;
		return new SuspendableFuture(function ($yield) use (&$f, &$_gthis) {
			return $f($_gthis->value->get())->handle($yield);
		});
	}

	/**
	 * @return SyncFuture
	 */
	public function gather () {
		return $this;
	}

	/**
	 * @param \Closure $cb
	 * 
	 * @return LinkObject
	 */
	public function handle ($cb) {
		Callback_Impl_::invoke($cb, $this->value->get());
		return null;
	}

	/**
	 * @param \Closure $f
	 * 
	 * @return FutureObject
	 */
	public function map ($f) {
		return new SyncFuture($this->value->map($f));
	}
}

Boot::registerClass(SyncFuture::class, 'tink.core._Future.SyncFuture');
