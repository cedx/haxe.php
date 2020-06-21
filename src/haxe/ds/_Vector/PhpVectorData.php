<?php
/**
 * Generated by Haxe 4.1.2
 */

namespace haxe\ds\_Vector;

use \php\Boot;

class PhpVectorData {
	/**
	 * @var mixed
	 */
	public $data;
	/**
	 * @var int
	 */
	public $length;

	/**
	 * @param int $length
	 * 
	 * @return void
	 */
	public function __construct ($length) {
		$this->length = $length;
		$this->data = [];
	}
}

Boot::registerClass(PhpVectorData::class, 'haxe.ds._Vector.PhpVectorData');
