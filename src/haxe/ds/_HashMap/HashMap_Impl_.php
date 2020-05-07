<?php
/**
 * Generated by Haxe 4.0.5
 */

namespace haxe\ds\_HashMap;

use \php\Boot;
use \php\_NativeIndexedArray\NativeIndexedArrayIterator;

final class HashMap_Impl_ {
	/**
	 * Creates a new HashMap.
	 * 
	 * @return HashMapData
	 */
	public static function _new () {
		$this1 = new HashMapData();
		return $this1;
	}

	/**
	 * See `Map.clear`
	 * 
	 * @param HashMapData $this
	 * 
	 * @return void
	 */
	public static function clear ($this1) {
		$_this = $this1->keys;
		$this2 = [];
		$_this->data = $this2;

		$_this1 = $this1->values;
		$this3 = [];
		$_this1->data = $this3;

	}

	/**
	 * See `Map.copy`
	 * 
	 * @param HashMapData $this
	 * 
	 * @return HashMapData
	 */
	public static function copy ($this1) {
		$copied = new HashMapData();
		$copied->keys = (clone $this1->keys);
		$copied->values = (clone $this1->values);
		return $copied;
	}

	/**
	 * See `Map.exists`
	 * 
	 * @param HashMapData $this
	 * @param mixed $k
	 * 
	 * @return bool
	 */
	public static function exists ($this1, $k) {
		$_this = $this1->values;
		return array_key_exists($k->hashCode(), $_this->data);
	}

	/**
	 * See `Map.get`
	 * 
	 * @param HashMapData $this
	 * @param mixed $k
	 * 
	 * @return mixed
	 */
	public static function get ($this1, $k) {
		$_this = $this1->values;
		$key = $k->hashCode();
		return ($_this->data[$key] ?? null);
	}

	/**
	 * See `Map.iterator`
	 * 
	 * @param HashMapData $this
	 * 
	 * @return object
	 */
	public static function iterator ($this1) {
		return new NativeIndexedArrayIterator(array_values($this1->values->data));
	}

	/**
	 * See `Map.keys`
	 * 
	 * @param HashMapData $this
	 * 
	 * @return object
	 */
	public static function keys ($this1) {
		return new NativeIndexedArrayIterator(array_values($this1->keys->data));
	}

	/**
	 * See `Map.remove`
	 * 
	 * @param HashMapData $this
	 * @param mixed $k
	 * 
	 * @return bool
	 */
	public static function remove ($this1, $k) {
		$this1->values->remove($k->hashCode());
		return $this1->keys->remove($k->hashCode());
	}

	/**
	 * See `Map.set`
	 * 
	 * @param HashMapData $this
	 * @param mixed $k
	 * @param mixed $v
	 * 
	 * @return void
	 */
	public static function set ($this1, $k, $v) {
		$_this = $this1->keys;
		$key = $k->hashCode();
		$_this->data[$key] = $k;

		$_this1 = $this1->values;
		$key1 = $k->hashCode();
		$_this1->data[$key1] = $v;

	}
}

Boot::registerClass(HashMap_Impl_::class, 'haxe.ds._HashMap.HashMap_Impl_');
