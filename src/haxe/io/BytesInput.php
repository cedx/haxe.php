<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace haxe\io;

use \haxe\io\_BytesData\Container;
use \php\Boot;
use \haxe\Exception;

class BytesInput extends Input {
	/**
	 * @var Container
	 */
	public $b;
	/**
	 * @var int
	 */
	public $len;
	/**
	 * @var int
	 */
	public $pos;
	/**
	 * @var int
	 */
	public $totlen;

	/**
	 * @param Bytes $b
	 * @param int $pos
	 * @param int $len
	 * 
	 * @return void
	 */
	public function __construct ($b, $pos = null, $len = null) {
		if ($pos === null) {
			$pos = 0;
		}
		if ($len === null) {
			$len = $b->length - $pos;
		}
		if (($pos < 0) || ($len < 0) || (($pos + $len) > $b->length)) {
			throw Exception::thrown(Error::OutsideBounds());
		}
		$this->b = $b->b;
		$this->pos = $pos;
		$this->len = $len;
		$this->totlen = $len;
	}

	/**
	 * @return int
	 */
	public function get_length () {
		return $this->totlen;
	}

	/**
	 * @return int
	 */
	public function get_position () {
		return $this->pos;
	}

	/**
	 * @return int
	 */
	public function readByte () {
		if ($this->len === 0) {
			throw Exception::thrown(new Eof());
		}
		--$this->len;
		return \ord($this->b->s[$this->pos++]);
	}

	/**
	 * @param Bytes $buf
	 * @param int $pos
	 * @param int $len
	 * 
	 * @return int
	 */
	public function readBytes ($buf, $pos, $len) {
		if (($pos < 0) || ($len < 0) || (($pos + $len) > $buf->length)) {
			throw Exception::thrown(Error::OutsideBounds());
		}
		if (($this->len === 0) && ($len > 0)) {
			throw Exception::thrown(new Eof());
		}
		if ($this->len < $len) {
			$len = $this->len;
		}
		$this1 = $buf->b;
		$src = $this->b;
		$srcpos = $this->pos;
		$this1->s = ((\substr($this1->s, 0, $pos) . \substr($src->s, $srcpos, $len)) . \substr($this1->s, $pos + $len));
		$this->pos += $len;
		$this->len -= $len;
		return $len;
	}

	/**
	 * @param int $p
	 * 
	 * @return int
	 */
	public function set_position ($p) {
		if ($p < 0) {
			$p = 0;
		} else if ($p > $this->totlen) {
			$p = $this->totlen;
		}
		$this->len = $this->totlen - $p;
		return $this->pos = $p;
	}
}

Boot::registerClass(BytesInput::class, 'haxe.io.BytesInput');
Boot::registerGetters('haxe\\io\\BytesInput', [
	'length' => true,
	'position' => true
]);
Boot::registerSetters('haxe\\io\\BytesInput', [
	'position' => true
]);
