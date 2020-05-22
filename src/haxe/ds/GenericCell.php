<?php
/**
 * Generated by Haxe 4.1.1
 */

namespace haxe\ds;

use \php\Boot;

/**
 * A cell of `haxe.ds.GenericStack`.
 * @see https://haxe.org/manual/std-GenericStack.html
 */
class GenericCell {
	/**
	 * @var mixed
	 */
	public $elt;
	/**
	 * @var GenericCell
	 */
	public $next;

	/**
	 * @param mixed $elt
	 * @param GenericCell $next
	 * 
	 * @return void
	 */
	public function __construct ($elt, $next) {
		$this->elt = $elt;
		$this->next = $next;
	}
}

Boot::registerClass(GenericCell::class, 'haxe.ds.GenericCell');