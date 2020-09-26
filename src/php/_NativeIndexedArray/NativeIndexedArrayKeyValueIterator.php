<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace php\_NativeIndexedArray;

use \php\_Boot\HxAnon;
use \php\Boot;

class NativeIndexedArrayKeyValueIterator {
	/**
	 * @var int
	 */
	public $current;
	/**
	 * @var mixed
	 */
	public $data;
	/**
	 * @var int
	 */
	public $length;

	/**
	 * @param mixed $data
	 * 
	 * @return void
	 */
	public function __construct ($data) {
		$this->current = 0;
		$this->length = \count($data);
		$this->data = $data;
	}

	/**
	 * @return bool
	 */
	public function hasNext () {
		return $this->current < $this->length;
	}

	/**
	 * @return object
	 */
	public function next () {
		$tmp = $this->current;
		return new HxAnon([
			"key" => $tmp,
			"value" => $this->data[$this->current++],
		]);
	}
}

Boot::registerClass(NativeIndexedArrayKeyValueIterator::class, 'php._NativeIndexedArray.NativeIndexedArrayKeyValueIterator');
