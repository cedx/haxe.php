<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace tink;

use \php\_Boot\HxAnon;
use \php\Boot;

class Anon {
	/**
	 * @param object $o
	 * 
	 * @return object
	 */
	public static function getExistentFields ($o) {
		$ret = new HxAnon();
		$_g = 0;
		$_g1 = \Reflect::fields($o);
		while ($_g < $_g1->length) {
			\Reflect::setField($ret, ($_g1->arr[$_g++] ?? null), true);
		}
		return $ret;
	}
}

Boot::registerClass(Anon::class, 'tink.Anon');
