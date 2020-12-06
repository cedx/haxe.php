<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace tink\streams\_Stream;

use \tink\streams\StreamBase;
use \tink\core\_Future\SyncFuture;
use \php\Boot;
use \tink\streams\Step;
use \tink\streams\StreamObject;
use \tink\core\_Lazy\LazyConst;
use \tink\streams\Empty_hx;
use \tink\core\_Future\Future_Impl_;
use \tink\streams\Conclusion;
use \tink\core\FutureObject;

class CompoundStream extends StreamBase {
	/**
	 * @var \Array_hx
	 */
	public $parts;

	/**
	 * @param \Array_hx $parts
	 * @param \Closure $handler
	 * @param \Closure $cb
	 * 
	 * @return void
	 */
	public static function consumeParts ($parts, $handler, $cb) {
		if ($parts->length === 0) {
			$cb(Conclusion::Depleted());
		} else {
			($parts->arr[0] ?? null)->forEach($handler)->handle(function ($o) use (&$parts, &$handler, &$cb) {
				$__hx__switch = ($o->index);
				if ($__hx__switch === 0) {
					$parts = (clone $parts);
					$parts->offsetSet(0, $o->params[0]);
					$cb(Conclusion::Halted(new CompoundStream($parts)));
				} else if ($__hx__switch === 1) {
					$_g = $o->params[1];
					if ($_g->get_depleted()) {
						$parts = $parts->slice(1);
					} else {
						$parts = (clone $parts);
						$parts->offsetSet(0, $_g);
					}
					$cb(Conclusion::Clogged($o->params[0], new CompoundStream($parts)));
				} else if ($__hx__switch === 2) {
					$cb(Conclusion::Failed($o->params[0]));
				} else if ($__hx__switch === 3) {
					CompoundStream::consumeParts($parts->slice(1), $handler, $cb);
				}
			});
		}
	}

	/**
	 * @param \Array_hx $streams
	 * 
	 * @return StreamObject
	 */
	public static function of ($streams) {
		$ret = new \Array_hx();
		$_g = 0;
		while ($_g < $streams->length) {
			($streams->arr[$_g++] ?? null)->decompose($ret);
		}
		if ($ret->length === 0) {
			return Empty_hx::$inst;
		} else {
			return new CompoundStream($ret);
		}
	}

	/**
	 * @param \Array_hx $parts
	 * 
	 * @return void
	 */
	public function __construct ($parts) {
		parent::__construct();
		$this->parts = $parts;
	}

	/**
	 * @param \Array_hx $into
	 * 
	 * @return void
	 */
	public function decompose ($into) {
		$_g = 0;
		$_g1 = $this->parts;
		while ($_g < $_g1->length) {
			($_g1->arr[$_g++] ?? null)->decompose($into);
		}
	}

	/**
	 * @param \Closure $handler
	 * 
	 * @return FutureObject
	 */
	public function forEach ($handler) {
		$parts = $this->parts;
		$handler1 = $handler;
		return Future_Impl_::async(function ($cb) use (&$handler1, &$parts) {
			CompoundStream::consumeParts($parts, $handler1, $cb);
		});
	}

	/**
	 * @return bool
	 */
	public function get_depleted () {
		$__hx__switch = ($this->parts->length);
		if ($__hx__switch === 0) {
			return true;
		} else if ($__hx__switch === 1) {
			return ($this->parts->arr[0] ?? null)->get_depleted();
		} else {
			return false;
		}
	}

	/**
	 * @return FutureObject
	 */
	public function next () {
		$_gthis = $this;
		if ($this->parts->length === 0) {
			return new SyncFuture(new LazyConst(Step::End()));
		} else {
			return ($this->parts->arr[0] ?? null)->next()->flatMap(function ($v) use (&$_gthis) {
				$__hx__switch = ($v->index);
				if ($__hx__switch === 0) {
					$copy = (clone $_gthis->parts);
					$copy->offsetSet(0, $v->params[1]);
					return new SyncFuture(new LazyConst(Step::Link($v->params[0], new CompoundStream($copy))));
				} else if ($__hx__switch === 2) {
					if ($_gthis->parts->length > 1) {
						return ($_gthis->parts->arr[1] ?? null)->next();
					} else {
						return new SyncFuture(new LazyConst($v));
					}
				} else {
					return new SyncFuture(new LazyConst($v));
				}
			})->gather();
		}
	}
}

Boot::registerClass(CompoundStream::class, 'tink.streams._Stream.CompoundStream');