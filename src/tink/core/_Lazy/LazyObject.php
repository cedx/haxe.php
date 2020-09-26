<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace tink\core\_Lazy;

use \php\Boot;

interface LazyObject {
	/**
	 * @param \Closure $f
	 * 
	 * @return LazyObject
	 */
	public function flatMap ($f) ;

	/**
	 * @return mixed
	 */
	public function get () ;

	/**
	 * @param \Closure $f
	 * 
	 * @return LazyObject
	 */
	public function map ($f) ;
}

Boot::registerClass(LazyObject::class, 'tink.core._Lazy.LazyObject');
