<?php
/**
 * Generated by Haxe 4.1.2
 */

namespace haxe\_EntryPoint;

use \php\Boot;

class Thread {
	/**
	 * @param \Closure $f
	 * 
	 * @return void
	 */
	public static function create ($f) {
		$f();
	}
}

Boot::registerClass(Thread::class, 'haxe._EntryPoint.Thread');
