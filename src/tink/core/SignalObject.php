<?php
/**
 * Generated by Haxe 4.1.3
 */

namespace tink\core;

use \php\Boot;

interface SignalObject {
	/**
	 *  Registers a callback to be invoked every time the signal is triggered
	 *  @return A `CallbackLink` instance that can be used to unregister the callback
	 * 
	 * @param \Closure $handler
	 * 
	 * @return LinkObject
	 */
	public function listen ($handler) ;
}

Boot::registerClass(SignalObject::class, 'tink.core.SignalObject');
