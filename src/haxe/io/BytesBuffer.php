<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace haxe\io;

use \haxe\io\_BytesData\Container;
use \haxe\_Int64\___Int64;
use \php\Boot;
use \haxe\Exception;

class BytesBuffer {
	/**
	 * @var mixed
	 */
	public $b;

	/**
	 * @return void
	 */
	public function __construct () {
		$this->b = "";
	}

	/**
	 * @param Bytes $src
	 * 
	 * @return void
	 */
	public function add ($src) {
		$this->b = ($this->b . $src->b->s);
	}

	/**
	 * @param int $byte
	 * 
	 * @return void
	 */
	public function addByte ($byte) {
		$this->b = ($this->b . \chr($byte));
	}

	/**
	 * @param Bytes $src
	 * @param int $pos
	 * @param int $len
	 * 
	 * @return void
	 */
	public function addBytes ($src, $pos, $len) {
		if (($pos < 0) || ($len < 0) || (($pos + $len) > $src->length)) {
			throw Exception::thrown(Error::OutsideBounds());
		} else {
			$this->b = ($this->b . \substr($src->b->s, $pos, $len));
		}
	}

	/**
	 * @param float $v
	 * 
	 * @return void
	 */
	public function addDouble ($v) {
		$this->addInt64(FPHelper::doubleToI64($v));
	}

	/**
	 * @param float $v
	 * 
	 * @return void
	 */
	public function addFloat ($v) {
		$this->addInt32(\unpack("l", \pack("f", $v))[1]);
	}

	/**
	 * @param int $v
	 * 
	 * @return void
	 */
	public function addInt32 ($v) {
		$this->b = ($this->b . \chr($v & 255));
		$this->b = ($this->b . \chr(($v >> 8) & 255));
		$this->b = ($this->b . \chr(($v >> 16) & 255));
		$this->b = ($this->b . \chr(Boot::shiftRightUnsigned($v, 24)));
	}

	/**
	 * @param ___Int64 $v
	 * 
	 * @return void
	 */
	public function addInt64 ($v) {
		$this->addInt32($v->low);
		$this->addInt32($v->high);
	}

	/**
	 * @param string $v
	 * @param Encoding $encoding
	 * 
	 * @return void
	 */
	public function addString ($v, $encoding = null) {
		$this->b = ($this->b . $v);
	}

	/**
	 * @return Bytes
	 */
	public function getBytes () {
		$bytes = \strlen($this->b);
		$bytes1 = new Bytes($bytes, new Container($this->b));
		$this->b = null;
		return $bytes1;
	}

	/**
	 * @return int
	 */
	public function get_length () {
		return \strlen($this->b);
	}
}

Boot::registerClass(BytesBuffer::class, 'haxe.io.BytesBuffer');
Boot::registerGetters('haxe\\io\\BytesBuffer', [
	'length' => true
]);
