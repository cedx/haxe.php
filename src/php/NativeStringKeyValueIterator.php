<?php
/**
 * Generated by Haxe 4.1.3
 */

namespace php;

use \php\_Boot\HxAnon;

class NativeStringKeyValueIterator {
	/**
	 * @var int
	 */
	public $i;
	/**
	 * @var mixed
	 */
	public $s;

	/**
	 * @param mixed $s
	 * 
	 * @return void
	 */
	public function __construct ($s) {
		$this->i = 0;
		$this->s = $s;
	}

	/**
	 * @return bool
	 */
	public function hasNext () {
		return $this->i < \strlen($this->s);
	}

	/**
	 * @return object
	 */
	public function next () {
		$tmp = $this->i;
		return new HxAnon([
			"key" => $tmp,
			"value" => $this->s[$this->i++],
		]);
	}
}

Boot::registerClass(NativeStringKeyValueIterator::class, 'php.NativeStringKeyValueIterator');
