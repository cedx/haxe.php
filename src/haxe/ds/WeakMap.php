<?php
/**
 * Generated by Haxe 4.1.1
 */

namespace haxe\ds;

use \php\Boot;
use \haxe\Exception;
use \haxe\IMap;

/**
 * WeakMap allows mapping of object keys to arbitrary values.
 * The keys are considered to be weak references on static targets.
 * See `Map` for documentation details.
 * @see https://haxe.org/manual/std-Map.html
 */
class WeakMap implements IMap {
	/**
	 * Creates a new WeakMap.
	 * 
	 * @return void
	 */
	public function __construct () {
		throw Exception::thrown("Not implemented for this platform");
	}

	/**
	 * See `Map.clear`
	 * 
	 * @return void
	 */
	public function clear () {
	}

	/**
	 * See `Map.copy`
	 * 
	 * @return WeakMap
	 */
	public function copy () {
		return null;
	}

	/**
	 * See `Map.exists`
	 * 
	 * @param mixed $key
	 * 
	 * @return bool
	 */
	public function exists ($key) {
		return false;
	}

	/**
	 * See `Map.get`
	 * 
	 * @param mixed $key
	 * 
	 * @return mixed
	 */
	public function get ($key) {
		return null;
	}

	/**
	 * See `Map.iterator`
	 * 
	 * @return object
	 */
	public function iterator () {
		return null;
	}

	/**
	 * See `Map.keyValueIterator`
	 * 
	 * @return object
	 */
	public function keyValueIterator () {
		return null;
	}

	/**
	 * See `Map.keys`
	 * 
	 * @return object
	 */
	public function keys () {
		return null;
	}

	/**
	 * See `Map.remove`
	 * 
	 * @param mixed $key
	 * 
	 * @return bool
	 */
	public function remove ($key) {
		return false;
	}

	/**
	 * See `Map.set`
	 * 
	 * @param mixed $key
	 * @param mixed $value
	 * 
	 * @return void
	 */
	public function set ($key, $value) {
	}

	/**
	 * See `Map.toString`
	 * 
	 * @return string
	 */
	public function toString () {
		return null;
	}

	public function __toString() {
		return $this->toString();
	}
}

Boot::registerClass(WeakMap::class, 'haxe.ds.WeakMap');
