<?php
/**
 * Generated by Haxe 4.1.1
 */

namespace haxe;

use \php\Boot;

/**
 * An exception containing arbitrary value.
 * This class is automatically used for throwing values, which don't extend `haxe.Exception`
 * or native exception type.
 * For example:
 * ```haxe
 * throw "Terrible error";
 * ```
 * will be compiled to
 * ```haxe
 * throw new ValueException("Terrible error");
 * ```
 */
class ValueException extends Exception {
	/**
	 * @var mixed
	 * Thrown value.
	 */
	public $value;

	/**
	 * @param mixed $value
	 * @param Exception $previous
	 * @param mixed $native
	 * 
	 * @return void
	 */
	public function __construct ($value, $previous = null, $native = null) {
		parent::__construct(\Std::string($value), $previous, $native);
		$this->value = $value;
	}

	/**
	 * Extract an originally thrown value.
	 * This method must return the same value on subsequent calls.
	 * Used internally for catching non-native exceptions.
	 * Do _not_ override unless you know what you are doing.
	 * 
	 * @return mixed
	 */
	public function unwrap () {
		return $this->value;
	}
}

Boot::registerClass(ValueException::class, 'haxe.ValueException');
