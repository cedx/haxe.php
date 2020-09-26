<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace haxe\ds;

use \php\Boot;
use \haxe\iterators\MapKeyValueIterator;
use \haxe\IMap;
use \php\_NativeIndexedArray\NativeIndexedArrayIterator;

/**
 * IntMap allows mapping of Int keys to arbitrary values.
 * See `Map` for documentation details.
 * @see https://haxe.org/manual/std-Map.html
 */
class IntMap implements IMap {
	/**
	 * @var mixed
	 */
	public $data;

	/**
	 * Creates a new IntMap.
	 * 
	 * @return void
	 */
	public function __construct () {
		$this->data = [];
	}

	/**
	 * See `Map.clear`
	 * 
	 * @return void
	 */
	public function clear () {
		$this->data = [];
	}

	/**
	 * See `Map.copy`
	 * 
	 * @return IntMap
	 */
	public function copy () {
		return (clone $this);
	}

	/**
	 * See `Map.exists`
	 * 
	 * @param int $key
	 * 
	 * @return bool
	 */
	public function exists ($key) {
		return \array_key_exists($key, $this->data);
	}

	/**
	 * See `Map.get`
	 * 
	 * @param int $key
	 * 
	 * @return mixed
	 */
	public function get ($key) {
		return ($this->data[$key] ?? null);
	}

	/**
	 * See `Map.iterator`
	 * (cs, java) Implementation detail: Do not `set()` any new value while
	 * iterating, as it may cause a resize, which will break iteration.
	 * 
	 * @return object
	 */
	public function iterator () {
		return new NativeIndexedArrayIterator(\array_values($this->data));
	}

	/**
	 * See `Map.keyValueIterator`
	 * 
	 * @return object
	 */
	public function keyValueIterator () {
		return new MapKeyValueIterator($this);
	}

	/**
	 * See `Map.keys`
	 * (cs, java) Implementation detail: Do not `set()` any new value while
	 * iterating, as it may cause a resize, which will break iteration.
	 * 
	 * @return object
	 */
	public function keys () {
		return new NativeIndexedArrayIterator(\array_keys($this->data));
	}

	/**
	 * See `Map.remove`
	 * 
	 * @param int $key
	 * 
	 * @return bool
	 */
	public function remove ($key) {
		if (\array_key_exists($key, $this->data)) {
			unset($this->data[$key]);
			return true;
		}
		return false;
	}

	/**
	 * See `Map.set`
	 * 
	 * @param int $key
	 * @param mixed $value
	 * 
	 * @return void
	 */
	public function set ($key, $value) {
		$this->data[$key] = $value;
	}

	/**
	 * See `Map.toString`
	 * 
	 * @return string
	 */
	public function toString () {
		$parts = [];
		$collection = $this->data;
		foreach ($collection as $key => $value) {
			\array_push($parts, "" . ($key??'null') . " => " . (\Std::string($value)??'null'));
		}
		return "{" . (\implode(", ", $parts)??'null') . "}";
	}

	public function __toString() {
		return $this->toString();
	}
}

Boot::registerClass(IntMap::class, 'haxe.ds.IntMap');
