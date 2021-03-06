<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace tink\url\_Host;

use \php\Boot;
use \haxe\Exception;
use \php\_Boot\HxString;

final class Host_Impl_ {

	/**
	 * @param string $name
	 * @param int $port
	 * 
	 * @return string
	 */
	public static function _new ($name, $port = null) {
		$this1 = null;
		if ($port === null) {
			$this1 = $name;
		} else if (($port > 65535) || ($port <= 0)) {
			throw Exception::thrown("Invalid port");
		} else {
			$this1 = "" . ($name??'null') . ":" . ($port??'null');
		}
		return $this1;
	}

	/**
	 * @param string $this
	 * 
	 * @return string
	 */
	public static function get_name ($this1) {
		if ($this1 === null) {
			return null;
		} else {
			$_g = HxString::split($this1, "]");
			$__hx__switch = ($_g->length);
			if ($__hx__switch === 1) {
				return (HxString::split(($_g->arr[0] ?? null), ":")->arr[0] ?? null);
			} else if ($__hx__switch === 2) {
				return (($_g->arr[0] ?? null)??'null') . "]";
			} else {
				throw Exception::thrown("assert");
			}
		}
	}

	/**
	 * @param string $this
	 * 
	 * @return int
	 */
	public static function get_port ($this1) {
		if ($this1 === null) {
			return null;
		} else {
			$_g = HxString::split($this1, "]");
			$__hx__switch = ($_g->length);
			if ($__hx__switch === 1) {
				$_g1 = (HxString::split(($_g->arr[0] ?? null), ":")->arr[1] ?? null);
				if ($_g1 === null) {
					return null;
				} else {
					return \Std::parseInt($_g1);
				}
			} else if ($__hx__switch === 2) {
				$_g1 = (HxString::split(($_g->arr[1] ?? null), ":")->arr[1] ?? null);
				if ($_g1 === null) {
					return null;
				} else {
					return \Std::parseInt($_g1);
				}
			} else {
				throw Exception::thrown("assert");
			}
		}
	}

	/**
	 * @param string $this
	 * 
	 * @return string
	 */
	public static function toString ($this1) {
		return $this1;
	}
}

Boot::registerClass(Host_Impl_::class, 'tink.url._Host.Host_Impl_');
Boot::registerGetters('tink\\url\\_Host\\Host_Impl_', [
	'port' => true,
	'name' => true
]);
