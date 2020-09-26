<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace tink\core;

use \php\Boot;
use \tink\core\_Callback\ListCell;

class SignalTrigger implements SignalObject {
	/**
	 * @var CallbackList
	 */
	public $handlers;

	/**
	 * @return void
	 */
	public function __construct () {
		$this->handlers = new CallbackList();
	}

	/**
	 * @return SignalObject
	 */
	public function asSignal () {
		return $this;
	}

	/**
	 *  Clear all handlers
	 * 
	 * @return void
	 */
	public function clear () {
		$this->handlers->clear();
	}

	/**
	 *  Gets the number of handlers registered
	 * 
	 * @return int
	 */
	public function getLength () {
		return $this->handlers->used;
	}

	/**
	 * @param \Closure $cb
	 * 
	 * @return LinkObject
	 */
	public function listen ($cb) {
		$_this = $this->handlers;
		$node = new ListCell($cb, $_this);
		$_this1 = $_this->cells;
		$_this1->arr[$_this1->length++] = $node;
		if ($_this->used++ === 0) {
			$_this->onfill();
		}
		return $node;
	}

	/**
	 *  Emits a value for this signal
	 * 
	 * @param mixed $event
	 * 
	 * @return void
	 */
	public function trigger ($event) {
		$this->handlers->invoke($event);
	}
}

Boot::registerClass(SignalTrigger::class, 'tink.core.SignalTrigger');
