<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace tink\streams;

use \haxe\ds\Option;
use \php\Boot;
use \tink\core\TypedError;
use \php\_Boot\HxEnum;

class RegroupResult extends HxEnum {
	/**
	 * @param StreamObject $data
	 * 
	 * @return RegroupResult
	 */
	static public function Converted ($data) {
		return new RegroupResult('Converted', 0, [$data]);
	}

	/**
	 * @param TypedError $e
	 * 
	 * @return RegroupResult
	 */
	static public function Errored ($e) {
		return new RegroupResult('Errored', 3, [$e]);
	}

	/**
	 * @param Option $data
	 * 
	 * @return RegroupResult
	 */
	static public function Terminated ($data) {
		return new RegroupResult('Terminated', 1, [$data]);
	}

	/**
	 * @return RegroupResult
	 */
	static public function Untouched () {
		static $inst = null;
		if (!$inst) $inst = new RegroupResult('Untouched', 2, []);
		return $inst;
	}

	/**
	 * Returns array of (constructorIndex => constructorName)
	 *
	 * @return string[]
	 */
	static public function __hx__list () {
		return [
			0 => 'Converted',
			3 => 'Errored',
			1 => 'Terminated',
			2 => 'Untouched',
		];
	}

	/**
	 * Returns array of (constructorName => parametersCount)
	 *
	 * @return int[]
	 */
	static public function __hx__paramsCount () {
		return [
			'Converted' => 1,
			'Errored' => 1,
			'Terminated' => 1,
			'Untouched' => 0,
		];
	}
}

Boot::registerClass(RegroupResult::class, 'tink.streams.RegroupResult');
