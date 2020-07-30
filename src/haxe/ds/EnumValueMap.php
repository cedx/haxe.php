<?php
/**
 * Generated by Haxe 4.1.3
 */

namespace haxe\ds;

use \php\Boot;
use \haxe\IMap;
use \php\_Boot\HxEnum;

/**
 * EnumValueMap allows mapping of enum value keys to arbitrary values.
 * Keys are compared by value and recursively over their parameters. If any
 * parameter is not an enum value, `Reflect.compare` is used to compare them.
 */
class EnumValueMap extends BalancedTree implements IMap {
	/**
	 * @return void
	 */
	public function __construct () {
		parent::__construct();
	}

	/**
	 * @param mixed $k1
	 * @param mixed $k2
	 * 
	 * @return int
	 */
	public function compare ($k1, $k2) {
		$d = $k1->index - $k2->index;
		if ($d !== 0) {
			return $d;
		}
		$p1 = \Array_hx::wrap($k1->params);
		$p2 = \Array_hx::wrap($k2->params);
		if (($p1->length === 0) && ($p2->length === 0)) {
			return 0;
		}
		return $this->compareArgs($p1, $p2);
	}

	/**
	 * @param mixed $v1
	 * @param mixed $v2
	 * 
	 * @return int
	 */
	public function compareArg ($v1, $v2) {
		if (($v1 instanceof HxEnum) && ($v2 instanceof HxEnum)) {
			return $this->compare($v1, $v2);
		} else if (($v1 instanceof \Array_hx) && ($v2 instanceof \Array_hx)) {
			return $this->compareArgs($v1, $v2);
		} else {
			return \Reflect::compare($v1, $v2);
		}
	}

	/**
	 * @param \Array_hx $a1
	 * @param \Array_hx $a2
	 * 
	 * @return int
	 */
	public function compareArgs ($a1, $a2) {
		$ld = $a1->length - $a2->length;
		if ($ld !== 0) {
			return $ld;
		}
		$_g = 0;
		$_g1 = $a1->length;
		while ($_g < $_g1) {
			$i = $_g++;
			$d = $this->compareArg(($a1->arr[$i] ?? null), ($a2->arr[$i] ?? null));
			if ($d !== 0) {
				return $d;
			}
		}
		return 0;
	}

	/**
	 * @return EnumValueMap
	 */
	public function copy () {
		$copied = new EnumValueMap();
		$copied->root = $this->root;
		return $copied;
	}
}

Boot::registerClass(EnumValueMap::class, 'haxe.ds.EnumValueMap');
