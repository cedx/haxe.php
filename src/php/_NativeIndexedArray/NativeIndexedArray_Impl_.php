<?php
/**
 * Generated by Haxe 4.0.5
 */

namespace php\_NativeIndexedArray;

use \php\Boot;

final class NativeIndexedArray_Impl_ {
	/**
	 * @return mixed
	 */
	public static function _new () {
		$this1 = [];
		return $this1;
	}

	/**
	 * @param \Array_hx $a
	 * 
	 * @return mixed
	 */
	public static function fromHaxeArray ($a) {
		return $a->arr;
	}

	/**
	 * @param mixed $this
	 * @param int $idx
	 * 
	 * @return mixed
	 */
	public static function get ($this1, $idx) {
		return $this1[$idx];
	}

	/**
	 * @param mixed $this
	 * 
	 * @return NativeIndexedArrayIterator
	 */
	public static function iterator ($this1) {
		return new NativeIndexedArrayIterator($this1);
	}

	/**
	 * @param mixed $this
	 * 
	 * @return NativeIndexedArrayKeyValueIterator
	 */
	public static function keyValueIterator ($this1) {
		return new NativeIndexedArrayKeyValueIterator($this1);
	}

	/**
	 * @param mixed $this
	 * @param mixed $val
	 * 
	 * @return void
	 */
	public static function push ($this1, $val) {
		$this1[] = $val;
	}

	/**
	 * @param mixed $this
	 * @param int $idx
	 * @param mixed $val
	 * 
	 * @return mixed
	 */
	public static function set ($this1, $idx, $val) {
		return $this1[$idx] = $val;
	}

	/**
	 * @param mixed $this
	 * 
	 * @return \Array_hx
	 */
	public static function toHaxeArray ($this1) {
		return \Array_hx::wrap($this1);
	}

	/**
	 * @param mixed $this
	 * 
	 * @return string
	 */
	public static function toString ($this1) {
		return Boot::stringifyNativeIndexedArray($this1);
	}
}

Boot::registerClass(NativeIndexedArray_Impl_::class, 'php._NativeIndexedArray.NativeIndexedArray_Impl_');
