<?php
/**
 * Generated by Haxe 4.1.3
 */

namespace php\_Boot;

use \php\Boot;
use \haxe\Exception;

/**
 * Closures implementation
 */
class HxClosure {
	/**
	 * @var mixed
	 * A callable value, which can be invoked by PHP
	 */
	public $callable;
	/**
	 * @var string
	 * Method name for methods
	 */
	public $func;
	/**
	 * @var mixed
	 * `this` for instance methods; php class name for static methods
	 */
	public $target;

	/**
	 * @param mixed $target
	 * @param string $func
	 * 
	 * @return void
	 */
	public function __construct ($target, $func) {
		$this->target = $target;
		$this->func = $func;
		if (\is_null($target)) {
			throw Exception::thrown("Unable to create closure on `null`");
		}
		$this->callable = (($target instanceof HxAnon) ? $target->{$func} : [$target, $func]);
	}

	/**
	 * @see http://php.net/manual/en/language.oop5.magic.php#object.invoke
	 * 
	 * @return mixed
	 */
	public function __invoke () {
		return \call_user_func_array($this->callable, \func_get_args());
	}

	/**
	 * Invoke this closure with `newThis` instead of `this`
	 * 
	 * @param mixed $newThis
	 * @param mixed $args
	 * 
	 * @return mixed
	 */
	public function callWith ($newThis, $args) {
		return \call_user_func_array($this->getCallback($newThis), $args);
	}

	/**
	 * Check if this is the same closure
	 * 
	 * @param HxClosure $closure
	 * 
	 * @return bool
	 */
	public function equals ($closure) {
		if (Boot::equal($this->target, $closure->target)) {
			return $this->func === $closure->func;
		} else {
			return false;
		}
	}

	/**
	 * Generates callable value for PHP
	 * 
	 * @param mixed $eThis
	 * 
	 * @return mixed
	 */
	public function getCallback ($eThis = null) {
		if ($eThis === null) {
			$eThis = $this->target;
		}
		if (($eThis instanceof HxAnon)) {
			return $eThis->{$this->func};
		}
		return [$eThis, $this->func];
	}
}

Boot::registerClass(HxClosure::class, 'php._Boot.HxClosure');
