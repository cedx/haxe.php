<?php
/**
 * Generated by Haxe 4.1.3
 */

namespace tink\core;

use \php\Boot;

class NamedWith {
	/**
	 * @var mixed
	 */
	public $name;
	/**
	 * @var mixed
	 */
	public $value;

	/**
	 * @param mixed $name
	 * @param mixed $value
	 * 
	 * @return void
	 */
	public function __construct ($name, $value) {
		$this->name = $name;
		$this->value = $value;
	}
}

Boot::registerClass(NamedWith::class, 'tink.core.NamedWith');
