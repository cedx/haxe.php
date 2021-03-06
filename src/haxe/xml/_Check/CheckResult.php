<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace haxe\xml\_Check;

use \php\Boot;
use \haxe\xml\Rule;
use \haxe\xml\Filter;
use \php\_Boot\HxEnum;

class CheckResult extends HxEnum {
	/**
	 * @param \Xml $x
	 * 
	 * @return CheckResult
	 */
	static public function CDataExpected ($x) {
		return new CheckResult('CDataExpected', 4, [$x]);
	}

	/**
	 * @param string $name
	 * @param \Xml $x
	 * 
	 * @return CheckResult
	 */
	static public function CElementExpected ($name, $x) {
		return new CheckResult('CElementExpected', 3, [$name, $x]);
	}

	/**
	 * @param \Xml $x
	 * 
	 * @return CheckResult
	 */
	static public function CExtra ($x) {
		return new CheckResult('CExtra', 2, [$x]);
	}

	/**
	 * @param string $att
	 * @param \Xml $x
	 * 
	 * @return CheckResult
	 */
	static public function CExtraAttrib ($att, $x) {
		return new CheckResult('CExtraAttrib', 5, [$att, $x]);
	}

	/**
	 * @param \Xml $x
	 * @param CheckResult $r
	 * 
	 * @return CheckResult
	 */
	static public function CInElement ($x, $r) {
		return new CheckResult('CInElement', 9, [$x, $r]);
	}

	/**
	 * @param string $att
	 * @param \Xml $x
	 * @param Filter $f
	 * 
	 * @return CheckResult
	 */
	static public function CInvalidAttrib ($att, $x, $f) {
		return new CheckResult('CInvalidAttrib', 7, [$att, $x, $f]);
	}

	/**
	 * @param \Xml $x
	 * @param Filter $f
	 * 
	 * @return CheckResult
	 */
	static public function CInvalidData ($x, $f) {
		return new CheckResult('CInvalidData', 8, [$x, $f]);
	}

	/**
	 * @return CheckResult
	 */
	static public function CMatch () {
		static $inst = null;
		if (!$inst) $inst = new CheckResult('CMatch', 0, []);
		return $inst;
	}

	/**
	 * @param Rule $r
	 * 
	 * @return CheckResult
	 */
	static public function CMissing ($r) {
		return new CheckResult('CMissing', 1, [$r]);
	}

	/**
	 * @param string $att
	 * @param \Xml $x
	 * 
	 * @return CheckResult
	 */
	static public function CMissingAttrib ($att, $x) {
		return new CheckResult('CMissingAttrib', 6, [$att, $x]);
	}

	/**
	 * Returns array of (constructorIndex => constructorName)
	 *
	 * @return string[]
	 */
	static public function __hx__list () {
		return [
			4 => 'CDataExpected',
			3 => 'CElementExpected',
			2 => 'CExtra',
			5 => 'CExtraAttrib',
			9 => 'CInElement',
			7 => 'CInvalidAttrib',
			8 => 'CInvalidData',
			0 => 'CMatch',
			1 => 'CMissing',
			6 => 'CMissingAttrib',
		];
	}

	/**
	 * Returns array of (constructorName => parametersCount)
	 *
	 * @return int[]
	 */
	static public function __hx__paramsCount () {
		return [
			'CDataExpected' => 1,
			'CElementExpected' => 2,
			'CExtra' => 1,
			'CExtraAttrib' => 2,
			'CInElement' => 2,
			'CInvalidAttrib' => 3,
			'CInvalidData' => 2,
			'CMatch' => 0,
			'CMissing' => 1,
			'CMissingAttrib' => 2,
		];
	}
}

Boot::registerClass(CheckResult::class, 'haxe.xml._Check.CheckResult');
