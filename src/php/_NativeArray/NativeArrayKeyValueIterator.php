<?php
/**
 * Generated by Haxe 4.0.5
 */

namespace php\_NativeArray;

use \php\_Boot\HxAnon;
use \php\Boot;

class NativeArrayKeyValueIterator {
	/**
	 * @var int
	 */
	public $current;
	/**
	 * @var mixed
	 */
	public $keys;
	/**
	 * @var int
	 */
	public $length;
	/**
	 * @var mixed
	 */
	public $values;

	/**
	 * @param mixed $data
	 * 
	 * @return void
	 */
	public function __construct ($data) {
		$this->current = 0;
		$this->length = count($data);
		$this->keys = array_keys($data);
		$this->values = array_values($data);
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
		$tmp = $this->keys[$this->current];
		return new HxAnon([
			"key" => $tmp,
			"value" => $this->values[$this->current++],
		]);
	}
}

Boot::registerClass(NativeArrayKeyValueIterator::class, 'php._NativeArray.NativeArrayKeyValueIterator');
