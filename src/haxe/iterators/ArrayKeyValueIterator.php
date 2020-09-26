<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace haxe\iterators;

use \php\_Boot\HxAnon;
use \php\Boot;

class ArrayKeyValueIterator {
	/**
	 * @var \Array_hx
	 */
	public $array;
	/**
	 * @var int
	 */
	public $current;

	/**
	 * @param \Array_hx $array
	 * 
	 * @return void
	 */
	public function __construct ($array) {
		$this->current = 0;
		$this->array = $array;
	}

	/**
	 * @return bool
	 */
	public function hasNext () {
		return $this->current < $this->array->length;
	}

	/**
	 * @return object
	 */
	public function next () {
		$tmp = ($this->array->arr[$this->current] ?? null);
		return new HxAnon([
			"value" => $tmp,
			"key" => $this->current++,
		]);
	}
}

Boot::registerClass(ArrayKeyValueIterator::class, 'haxe.iterators.ArrayKeyValueIterator');
