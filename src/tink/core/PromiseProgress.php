<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace tink\core;

use \tink\core\_Signal\Signal_Impl_;
use \tink\core\_Future\SyncFuture;
use \php\Boot;
use \tink\core\_Lazy\LazyConst;

class PromiseProgress extends CompositeProgress {
	/**
	 * @param FutureObject $promise
	 * 
	 * @return void
	 */
	public function __construct ($promise) {
		parent::__construct($promise->flatMap(function ($o) {
			$__hx__switch = ($o->index);
			if ($__hx__switch === 0) {
				return $o->params[0]->map(Boot::getStaticClosure(Outcome::class, 'Success'));
			} else if ($__hx__switch === 1) {
				return new SyncFuture(new LazyConst(Outcome::Failure($o->params[0])));
			}
		})->gather(), Signal_Impl_::generate(function ($cb) use (&$promise) {
			$promise->handle(function ($o) use (&$cb) {
				$__hx__switch = ($o->index);
				if ($__hx__switch === 0) {
					$o->params[0]->listen($cb);
				} else if ($__hx__switch === 1) {
				}
			});
		}));
	}
}

Boot::registerClass(PromiseProgress::class, 'tink.core.PromiseProgress');
