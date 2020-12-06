<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace tink\streams;

use \php\Boot;
use \tink\core\TypedError;
use \php\_Boot\HxEnum;

class ReductionStep extends HxEnum {
	/**
	 * @param TypedError $e
	 * 
	 * @return ReductionStep
	 */
	static public function Crash ($e) {
		return new ReductionStep('Crash', 1, [$e]);
	}

	/**
	 * @param mixed $result
	 * 
	 * @return ReductionStep
	 */
	static public function Progress ($result) {
		return new ReductionStep('Progress', 0, [$result]);
	}

	/**
	 * Returns array of (constructorIndex => constructorName)
	 *
	 * @return string[]
	 */
	static public function __hx__list () {
		return [
			1 => 'Crash',
			0 => 'Progress',
		];
	}

	/**
	 * Returns array of (constructorName => parametersCount)
	 *
	 * @return int[]
	 */
	static public function __hx__paramsCount () {
		return [
			'Crash' => 1,
			'Progress' => 1,
		];
	}
}

Boot::registerClass(ReductionStep::class, 'tink.streams.ReductionStep');
