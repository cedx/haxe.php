<?php
/**
 * Generated by Haxe 4.1.2
 */

namespace tink\core\_Callback;

use \php\Boot;
use \tink\core\LinkObject;

class LinkPair implements LinkObject {
	/**
	 * @var LinkObject
	 */
	public $a;
	/**
	 * @var LinkObject
	 */
	public $b;
	/**
	 * @var bool
	 */
	public $dissolved;

	/**
	 * @param LinkObject $a
	 * @param LinkObject $b
	 * 
	 * @return void
	 */
	public function __construct ($a, $b) {
		$this->dissolved = false;
		$this->a = $a;
		$this->b = $b;
	}

	/**
	 * @return void
	 */
	public function cancel () {
		if (!$this->dissolved) {
			$this->dissolved = true;
			$this1 = $this->a;
			if ($this1 !== null) {
				$this1->cancel();
			}
			$this1 = $this->b;
			if ($this1 !== null) {
				$this1->cancel();
			}
			$this->a = null;
			$this->b = null;
		}
	}
}

Boot::registerClass(LinkPair::class, 'tink.core._Callback.LinkPair');
