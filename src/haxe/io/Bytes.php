<?php
/**
 * Generated by Haxe 4.1.1
 */

namespace haxe\io;

use \haxe\io\_BytesData\Container;
use \haxe\_Int64\___Int64;
use \php\Boot;
use \haxe\Exception;

class Bytes {
	/**
	 * @var Container
	 */
	public $b;
	/**
	 * @var int
	 */
	public $length;

	/**
	 * @param int $length
	 * 
	 * @return Bytes
	 */
	public static function alloc ($length) {
		return new Bytes($length, new Container(str_repeat(chr(0), $length)));
	}

	/**
	 * @param Container $b
	 * @param int $pos
	 * 
	 * @return int
	 */
	public static function fastGet ($b, $pos) {
		return ord($b->s[$pos]);
	}

	/**
	 * @param Container $b
	 * 
	 * @return Bytes
	 */
	public static function ofData ($b) {
		return new Bytes(strlen($b->s), $b);
	}

	/**
	 * @param string $s
	 * 
	 * @return Bytes
	 */
	public static function ofHex ($s) {
		$len = strlen($s);
		if (($len & 1) !== 0) {
			throw Exception::thrown("Not a hex string (odd number of digits)");
		}
		$b = hex2bin($s);
		$tmp = strlen($b);
		return new Bytes($tmp, new Container($b));
	}

	/**
	 * @param string $s
	 * @param Encoding $encoding
	 * 
	 * @return Bytes
	 */
	public static function ofString ($s, $encoding = null) {
		$tmp = strlen($s);
		return new Bytes($tmp, new Container($s));
	}

	/**
	 * @param int $length
	 * @param Container $b
	 * 
	 * @return void
	 */
	public function __construct ($length, $b) {
		$this->length = $length;
		$this->b = $b;
	}

	/**
	 * @param int $pos
	 * @param Bytes $src
	 * @param int $srcpos
	 * @param int $len
	 * 
	 * @return void
	 */
	public function blit ($pos, $src, $srcpos, $len) {
		if (($pos < 0) || ($srcpos < 0) || ($len < 0) || (($pos + $len) > $this->length) || (($srcpos + $len) > $src->length)) {
			throw Exception::thrown(Error::OutsideBounds());
		} else {
			$this1 = $this->b;
			$src1 = $src->b;
			$this1->s = ((substr($this1->s, 0, $pos) . substr($src1->s, $srcpos, $len)) . substr($this1->s, $pos + $len));
		}
	}

	/**
	 * @param Bytes $other
	 * 
	 * @return int
	 */
	public function compare ($other) {
		return ($this->b->s <=> $other->b->s);
	}

	/**
	 * @param int $pos
	 * @param int $len
	 * @param int $value
	 * 
	 * @return void
	 */
	public function fill ($pos, $len, $value) {
		$_g = $pos;
		$_g1 = $pos + $len;
		while ($_g < $_g1) {
			$i = $_g++;
			$this->b->s[$i] = chr($value);
		}
	}

	/**
	 * @param int $pos
	 * 
	 * @return int
	 */
	public function get ($pos) {
		return ord($this->b->s[$pos]);
	}

	/**
	 * @return Container
	 */
	public function getData () {
		return $this->b;
	}

	/**
	 * @param int $pos
	 * 
	 * @return float
	 */
	public function getDouble ($pos) {
		$v = ord($this->b->s[$pos]) | (ord($this->b->s[$pos + 1]) << 8) | (ord($this->b->s[$pos + 2]) << 16) | (ord($this->b->s[$pos + 3]) << 24);
		$low = (($v & ((int)-2147483648)) !== 0 ? $v | ((int)-2147483648) : $v);
		$pos1 = $pos + 4;
		$v = ord($this->b->s[$pos1]) | (ord($this->b->s[$pos1 + 1]) << 8) | (ord($this->b->s[$pos1 + 2]) << 16) | (ord($this->b->s[$pos1 + 3]) << 24);
		$high = (($v & ((int)-2147483648)) !== 0 ? $v | ((int)-2147483648) : $v);
		return unpack("d", pack("ii", (FPHelper::$isLittleEndian ? $low : $high), (FPHelper::$isLittleEndian ? $high : $low)))[1];
	}

	/**
	 * @param int $pos
	 * 
	 * @return float
	 */
	public function getFloat ($pos) {
		$b = new BytesInput($this, $pos, 4);
		return $b->readFloat();
	}

	/**
	 * @param int $pos
	 * 
	 * @return int
	 */
	public function getInt32 ($pos) {
		$v = ord($this->b->s[$pos]) | (ord($this->b->s[$pos + 1]) << 8) | (ord($this->b->s[$pos + 2]) << 16) | (ord($this->b->s[$pos + 3]) << 24);
		if (($v & ((int)-2147483648)) !== 0) {
			return $v | ((int)-2147483648);
		} else {
			return $v;
		}
	}

	/**
	 * @param int $pos
	 * 
	 * @return ___Int64
	 */
	public function getInt64 ($pos) {
		$pos1 = $pos + 4;
		$v = ord($this->b->s[$pos1]) | (ord($this->b->s[$pos1 + 1]) << 8) | (ord($this->b->s[$pos1 + 2]) << 16) | (ord($this->b->s[$pos1 + 3]) << 24);
		$v1 = ord($this->b->s[$pos]) | (ord($this->b->s[$pos + 1]) << 8) | (ord($this->b->s[$pos + 2]) << 16) | (ord($this->b->s[$pos + 3]) << 24);
		$this1 = new ___Int64((($v & ((int)-2147483648)) !== 0 ? $v | ((int)-2147483648) : $v), (($v1 & ((int)-2147483648)) !== 0 ? $v1 | ((int)-2147483648) : $v1));
		return $this1;
	}

	/**
	 * @param int $pos
	 * @param int $len
	 * @param Encoding $encoding
	 * 
	 * @return string
	 */
	public function getString ($pos, $len, $encoding = null) {
		if (($pos < 0) || ($len < 0) || (($pos + $len) > $this->length)) {
			throw Exception::thrown(Error::OutsideBounds());
		} else {
			return substr($this->b->s, $pos, $len);
		}
	}

	/**
	 * @param int $pos
	 * 
	 * @return int
	 */
	public function getUInt16 ($pos) {
		return ord($this->b->s[$pos]) | (ord($this->b->s[$pos + 1]) << 8);
	}

	/**
	 * @param int $pos
	 * @param int $len
	 * 
	 * @return string
	 */
	public function readString ($pos, $len) {
		if (($pos < 0) || ($len < 0) || (($pos + $len) > $this->length)) {
			throw Exception::thrown(Error::OutsideBounds());
		} else {
			return substr($this->b->s, $pos, $len);
		}
	}

	/**
	 * @param int $pos
	 * @param int $v
	 * 
	 * @return void
	 */
	public function set ($pos, $v) {
		$this->b->s[$pos] = chr($v);
	}

	/**
	 * @param int $pos
	 * @param float $v
	 * 
	 * @return void
	 */
	public function setDouble ($pos, $v) {
		$i = FPHelper::doubleToI64($v);
		$v = $i->low;
		$this->b->s[$pos] = chr($v);
		$this->b->s[$pos + 1] = chr($v >> 8);
		$this->b->s[$pos + 2] = chr($v >> 16);
		$this->b->s[$pos + 3] = chr(Boot::shiftRightUnsigned($v, 24));
		$pos1 = $pos + 4;
		$v = $i->high;
		$this->b->s[$pos1] = chr($v);
		$this->b->s[$pos1 + 1] = chr($v >> 8);
		$this->b->s[$pos1 + 2] = chr($v >> 16);
		$this->b->s[$pos1 + 3] = chr(Boot::shiftRightUnsigned($v, 24));
	}

	/**
	 * @param int $pos
	 * @param float $v
	 * 
	 * @return void
	 */
	public function setFloat ($pos, $v) {
		$v1 = unpack("l", pack("f", $v))[1];
		$this->b->s[$pos] = chr($v1);
		$this->b->s[$pos + 1] = chr($v1 >> 8);
		$this->b->s[$pos + 2] = chr($v1 >> 16);
		$this->b->s[$pos + 3] = chr(Boot::shiftRightUnsigned($v1, 24));
	}

	/**
	 * @param int $pos
	 * @param int $v
	 * 
	 * @return void
	 */
	public function setInt32 ($pos, $v) {
		$this->b->s[$pos] = chr($v);
		$this->b->s[$pos + 1] = chr($v >> 8);
		$this->b->s[$pos + 2] = chr($v >> 16);
		$this->b->s[$pos + 3] = chr(Boot::shiftRightUnsigned($v, 24));
	}

	/**
	 * @param int $pos
	 * @param ___Int64 $v
	 * 
	 * @return void
	 */
	public function setInt64 ($pos, $v) {
		$v1 = $v->low;
		$this->b->s[$pos] = chr($v1);
		$this->b->s[$pos + 1] = chr($v1 >> 8);
		$this->b->s[$pos + 2] = chr($v1 >> 16);
		$this->b->s[$pos + 3] = chr(Boot::shiftRightUnsigned($v1, 24));
		$pos1 = $pos + 4;
		$v1 = $v->high;
		$this->b->s[$pos1] = chr($v1);
		$this->b->s[$pos1 + 1] = chr($v1 >> 8);
		$this->b->s[$pos1 + 2] = chr($v1 >> 16);
		$this->b->s[$pos1 + 3] = chr(Boot::shiftRightUnsigned($v1, 24));
	}

	/**
	 * @param int $pos
	 * @param int $v
	 * 
	 * @return void
	 */
	public function setUInt16 ($pos, $v) {
		$this->b->s[$pos] = chr($v);
		$this->b->s[$pos + 1] = chr($v >> 8);
	}

	/**
	 * @param int $pos
	 * @param int $len
	 * 
	 * @return Bytes
	 */
	public function sub ($pos, $len) {
		if (($pos < 0) || ($len < 0) || (($pos + $len) > $this->length)) {
			throw Exception::thrown(Error::OutsideBounds());
		} else {
			return new Bytes($len, new Container(substr($this->b->s, $pos, $len)));
		}
	}

	/**
	 * @return string
	 */
	public function toHex () {
		return bin2hex($this->b->s);
	}

	/**
	 * @return string
	 */
	public function toString () {
		return $this->b->s;
	}

	public function __toString() {
		return $this->toString();
	}
}

Boot::registerClass(Bytes::class, 'haxe.io.Bytes');
