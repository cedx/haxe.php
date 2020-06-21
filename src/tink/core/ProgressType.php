<?php
/**
 * Generated by Haxe 4.1.2
 */

namespace tink\core;

use \php\Boot;
use \php\_Boot\HxEnum;

class ProgressType extends HxEnum {
	/**
	 * @param mixed $v
	 * 
	 * @return ProgressType
	 */
	static public function Finished ($v) {
		return new ProgressType('Finished', 1, [$v]);
	}

	/**
	 * @param MPair $v
	 * 
	 * @return ProgressType
	 */
	static public function InProgress ($v) {
		return new ProgressType('InProgress', 0, [$v]);
	}

	/**
	 * Returns array of (constructorIndex => constructorName)
	 *
	 * @return string[]
	 */
	static public function __hx__list () {
		return [
			1 => 'Finished',
			0 => 'InProgress',
		];
	}

	/**
	 * Returns array of (constructorName => parametersCount)
	 *
	 * @return int[]
	 */
	static public function __hx__paramsCount () {
		return [
			'Finished' => 1,
			'InProgress' => 1,
		];
	}
}

Boot::registerClass(ProgressType::class, 'tink.core.ProgressType');
