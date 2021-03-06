<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace haxe\iterators;

use \php\Boot;

/**
 * This iterator can be used to iterate over the values of `haxe.DynamicAccess`.
 */
class DynamicAccessIterator {
	/**
	 * @var mixed
	 */
	public $access;
	/**
	 * @var int
	 */
	public $index;
	/**
	 * @var \Array_hx
	 */
	public $keys;

	/**
	 * @param mixed $access
	 * 
	 * @return void
	 */
	public function __construct ($access) {
		$this->access = $access;
		$this->keys = \Reflect::fields($access);
		$this->index = 0;
	}

	/**
	 * See `Iterator.hasNext`
	 * 
	 * @return bool
	 */
	public function hasNext () {
		return $this->index < $this->keys->length;
	}

	/**
	 * See `Iterator.next`
	 * 
	 * @return mixed
	 */
	public function next () {
		return \Reflect::field($this->access, ($this->keys->arr[$this->index++] ?? null));
	}
}

Boot::registerClass(DynamicAccessIterator::class, 'haxe.iterators.DynamicAccessIterator');
