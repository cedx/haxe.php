<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace tink\core\_Signal;

use \php\Boot;
use \tink\core\LinkObject;
use \tink\core\SignalObject;

class SimpleSignal implements SignalObject {
	/**
	 * @var \Closure
	 */
	public $f;

	/**
	 * @param \Closure $f
	 * 
	 * @return void
	 */
	public function __construct ($f) {
		$this->f = $f;
	}

	/**
	 * @param \Closure $cb
	 * 
	 * @return LinkObject
	 */
	public function listen ($cb) {
		return ($this->f)($cb);
	}
}

Boot::registerClass(SimpleSignal::class, 'tink.core._Signal.SimpleSignal');
