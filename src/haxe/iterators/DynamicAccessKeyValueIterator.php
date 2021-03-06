<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace haxe\iterators;

use \php\_Boot\HxAnon;
use \php\Boot;

/**
 * This Key/Value iterator can be used to iterate over `haxe.DynamicAccess`.
 */
class DynamicAccessKeyValueIterator {
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
	 * @return object
	 */
	public function next () {
		$key = ($this->keys->arr[$this->index++] ?? null);
		return new HxAnon([
			"value" => \Reflect::field($this->access, $key),
			"key" => $key,
		]);
	}
}

Boot::registerClass(DynamicAccessKeyValueIterator::class, 'haxe.iterators.DynamicAccessKeyValueIterator');
