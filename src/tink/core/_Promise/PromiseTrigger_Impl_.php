<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace tink\core\_Promise;

use \php\Boot;
use \tink\core\TypedError;
use \tink\core\Outcome;
use \tink\core\FutureTrigger;
use \tink\core\FutureObject;

final class PromiseTrigger_Impl_ {
	/**
	 * @return FutureTrigger
	 */
	public static function _new () {
		return new FutureTrigger();
	}

	/**
	 * @param FutureTrigger $this
	 * 
	 * @return FutureObject
	 */
	public static function asPromise ($this1) {
		return $this1;
	}

	/**
	 * @param FutureTrigger $this
	 * @param TypedError $e
	 * 
	 * @return bool
	 */
	public static function reject ($this1, $e) {
		return $this1->trigger(Outcome::Failure($e));
	}

	/**
	 * @param FutureTrigger $this
	 * @param mixed $v
	 * 
	 * @return bool
	 */
	public static function resolve ($this1, $v) {
		return $this1->trigger(Outcome::Success($v));
	}
}

Boot::registerClass(PromiseTrigger_Impl_::class, 'tink.core._Promise.PromiseTrigger_Impl_');
