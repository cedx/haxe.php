<?php
/**
 * Generated by Haxe 4.1.2
 */

namespace php\_NativeAssocArray;

use \php\Boot;
use \php\_NativeIndexedArray\NativeIndexedArrayIterator;

final class NativeAssocArray_Impl_ {
	/**
	 * @return mixed
	 */
	public static function _new () {
		return [];
	}

	/**
	 * @param mixed $this
	 * @param string $key
	 * 
	 * @return mixed
	 */
	public static function get ($this1, $key) {
		return $this1[$key];
	}

	/**
	 * @param mixed $this
	 * 
	 * @return NativeIndexedArrayIterator
	 */
	public static function iterator ($this1) {
		return new NativeIndexedArrayIterator(array_values($this1));
	}

	/**
	 * @param mixed $this
	 * 
	 * @return NativeAssocArrayKeyValueIterator
	 */
	public static function keyValueIterator ($this1) {
		return new NativeAssocArrayKeyValueIterator($this1);
	}

	/**
	 * @param mixed $this
	 * @param string $key
	 * @param mixed $val
	 * 
	 * @return mixed
	 */
	public static function set ($this1, $key, $val) {
		return $this1[$key] = $val;
	}
}

Boot::registerClass(NativeAssocArray_Impl_::class, 'php._NativeAssocArray.NativeAssocArray_Impl_');
