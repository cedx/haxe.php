<?php
/**
 * Generated by Haxe 4.1.2
 */

namespace thenshim\fallback;

use \php\Boot;
use \php\_Boot\HxClosure;
use \thenshim\Thenable;

/**
 * Promise/A+ implementation for providing a fallback/shim for targets
 * without promise support.
 */
class FallbackPromise implements Thenable {
	/**
	 * @var mixed
	 */
	public $reason;
	/**
	 * @var TaskScheduler
	 */
	public $scheduler;
	/**
	 * @var \Array_hx
	 */
	public $sessions;
	/**
	 * @var PromiseState
	 */
	public $state;
	/**
	 * @var mixed
	 */
	public $value;

	/**
	 * @param TaskScheduler $scheduler
	 * 
	 * @return void
	 */
	public function __construct ($scheduler) {
		$this->state = PromiseState::Pending();
		$this->scheduler = $scheduler;
		$this->sessions = new \Array_hx();
	}

	/**
	 * @param mixed $reason
	 * 
	 * @return void
	 */
	public function reject ($reason) {
		if ($this->state !== PromiseState::Pending()) {
			return;
		}
		$this->state = PromiseState::Rejected();
		$this->reason = $reason;
		$_g = 0;
		$_g1 = $this->sessions;
		while ($_g < $_g1->length) {
			($_g1->arr[$_g++] ?? null)->reject($reason);
		}
		$this->sessions->resize(0);
	}

	/**
	 * @param mixed $value
	 * 
	 * @return void
	 */
	public function resolve ($value) {
		if ($this->state !== PromiseState::Pending()) {
			return;
		}
		$this->state = PromiseState::Fulfilled();
		$this->value = $value;
		$_g = 0;
		$_g1 = $this->sessions;
		while ($_g < $_g1->length) {
			($_g1->arr[$_g++] ?? null)->resolve($value);
		}
		$this->sessions->resize(0);
	}

	/**
	 * @param \Closure $onFulfilled
	 * @param \Closure $onRejected
	 * 
	 * @return Thenable
	 */
	public function then ($onFulfilled, $onRejected = null) {
		return $this->thenImpl($onFulfilled, $onRejected);
	}

	/**
	 * @param mixed $onFulfilled
	 * @param mixed $onRejected
	 * 
	 * @return FallbackPromise
	 */
	public function thenImpl ($onFulfilled, $onRejected) {
		$session = $this->scheduler;
		$f = $onFulfilled;
		$session1 = ($f instanceof \Closure) || ($f instanceof HxClosure);
		$f = $onRejected;
		$session2 = ($f instanceof \Closure) || ($f instanceof HxClosure);
		$session3 = new HandlerSession($session, ($session1 ? $onFulfilled : null), ($session2 ? $onRejected : null));
		$__hx__switch = ($this->state->index);
		if ($__hx__switch === 0) {
			$_this = $this->sessions;
			$_this->arr[$_this->length++] = $session3;
		} else if ($__hx__switch === 1) {
			$session3->resolve($this->value);
		} else if ($__hx__switch === 2) {
			$session3->reject($this->reason);
		}
		return $session3->promise;
	}
}

Boot::registerClass(FallbackPromise::class, 'thenshim.fallback.FallbackPromise');
