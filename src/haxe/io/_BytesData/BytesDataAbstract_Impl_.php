<?php
/**
 * Generated by Haxe 4.1.3
 */

namespace haxe\io\_BytesData;

use \php\Boot;

final class BytesDataAbstract_Impl_ {

	/**
	 * @param int $length
	 * 
	 * @return Container
	 */
	public static function alloc ($length) {
		return new Container(\str_repeat(\chr(0), $length));
	}

	/**
	 * @param Container $this
	 * @param int $pos
	 * @param Container $src
	 * @param int $srcpos
	 * @param int $len
	 * 
	 * @return void
	 */
	public static function blit ($this1, $pos, $src, $srcpos, $len) {
		$this1->s = ((\substr($this1->s, 0, $pos) . \substr($src->s, $srcpos, $len)) . \substr($this1->s, $pos + $len));
	}

	/**
	 * @param Container $this
	 * @param Container $other
	 * 
	 * @return int
	 */
	public static function compare ($this1, $other) {
		return ($this1->s <=> $other->s);
	}

	/**
	 * @param mixed $s
	 * 
	 * @return Container
	 */
	public static function fromNativeString ($s) {
		return new Container($s);
	}

	/**
	 * @param string $s
	 * 
	 * @return Container
	 */
	public static function fromString ($s) {
		return new Container($s);
	}

	/**
	 * @param Container $this
	 * @param int $pos
	 * 
	 * @return int
	 */
	public static function get ($this1, $pos) {
		return \ord($this1->s[$pos]);
	}

	/**
	 * @param Container $this
	 * @param int $pos
	 * @param int $len
	 * 
	 * @return string
	 */
	public static function getString ($this1, $pos, $len) {
		return \substr($this1->s, $pos, $len);
	}

	/**
	 * @param Container $this
	 * 
	 * @return int
	 */
	public static function get_length ($this1) {
		return \strlen($this1->s);
	}

	/**
	 * @param Container $this
	 * @param int $index
	 * @param int $val
	 * 
	 * @return void
	 */
	public static function set ($this1, $index, $val) {
		$this1->s[$index] = \chr($val);
	}

	/**
	 * @param Container $this
	 * @param int $pos
	 * @param int $len
	 * 
	 * @return Container
	 */
	public static function sub ($this1, $pos, $len) {
		return new Container(\substr($this1->s, $pos, $len));
	}

	/**
	 * @param Container $this
	 * 
	 * @return mixed
	 */
	public static function toNativeString ($this1) {
		return $this1->s;
	}

	/**
	 * @param Container $this
	 * 
	 * @return string
	 */
	public static function toString ($this1) {
		return $this1->s;
	}
}

Boot::registerClass(BytesDataAbstract_Impl_::class, 'haxe.io._BytesData.BytesDataAbstract_Impl_');
Boot::registerGetters('haxe\\io\\_BytesData\\BytesDataAbstract_Impl_', [
	'length' => true
]);
