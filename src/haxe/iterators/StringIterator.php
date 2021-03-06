<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace haxe\iterators;

use \php\Boot;

/**
 * This iterator can be used to iterate over char codes in a string.
 * Note that char codes may differ across platforms because of different
 * internal encoding of strings in different of runtimes.
 */
class StringIterator {
	/**
	 * @var int
	 */
	public $offset;
	/**
	 * @var string
	 */
	public $s;

	/**
	 * Create a new `StringIterator` over String `s`.
	 * 
	 * @param string $s
	 * 
	 * @return void
	 */
	public function __construct ($s) {
		$this->offset = 0;
		$this->s = $s;
	}

	/**
	 * See `Iterator.hasNext`
	 * 
	 * @return bool
	 */
	public function hasNext () {
		return $this->offset < mb_strlen($this->s);
	}

	/**
	 * See `Iterator.next`
	 * 
	 * @return int
	 */
	public function next () {
		return \StringTools::fastCodeAt($this->s, $this->offset++);
	}
}

Boot::registerClass(StringIterator::class, 'haxe.iterators.StringIterator');
