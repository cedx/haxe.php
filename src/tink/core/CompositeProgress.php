<?php
/**
 * Generated by Haxe 4.1.3
 */

namespace tink\core;

use \php\Boot;

class CompositeProgress implements ProgressObject {
	/**
	 * @var FutureObject
	 */
	public $future;
	/**
	 * @var SignalObject
	 */
	public $signal;

	/**
	 * @param FutureObject $future
	 * @param SignalObject $signal
	 * 
	 * @return void
	 */
	public function __construct ($future, $signal) {
		$this->future = $future;
		$this->signal = $signal;
	}

	/**
	 * @return FutureObject
	 */
	public function eager () {
		return $this->future->eager();
	}

	/**
	 * @param \Closure $f
	 * 
	 * @return FutureObject
	 */
	public function flatMap ($f) {
		return $this->future->flatMap($f)->gather();
	}

	/**
	 * @return FutureObject
	 */
	public function gather () {
		return $this->future->gather();
	}

	/**
	 * @param \Closure $callback
	 * 
	 * @return LinkObject
	 */
	public function handle ($callback) {
		return $this->future->handle($callback);
	}

	/**
	 * @param \Closure $callback
	 * 
	 * @return LinkObject
	 */
	public function listen ($callback) {
		return $this->signal->listen($callback);
	}

	/**
	 * @param \Closure $f
	 * 
	 * @return FutureObject
	 */
	public function map ($f) {
		return $this->future->map($f)->gather();
	}
}

Boot::registerClass(CompositeProgress::class, 'tink.core.CompositeProgress');
