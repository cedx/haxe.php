<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace tink\core;

use \tink\core\_Signal\Signal_Impl_;
use \php\Boot;

class FutureProgress extends CompositeProgress {
	/**
	 * @param FutureObject $future
	 * 
	 * @return void
	 */
	public function __construct ($future) {
		parent::__construct($future->flatMap(function ($progress) {
			return $progress;
		})->gather(), Signal_Impl_::generate(function ($cb) use (&$future) {
			$future->handle(function ($progress) use (&$cb) {
				$progress->listen($cb);
			});
		}));
	}
}

Boot::registerClass(FutureProgress::class, 'tink.core.FutureProgress');
