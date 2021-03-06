<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace tink\url\_Path;

use \php\Boot;
use \php\_Boot\HxString;

final class Path_Impl_ {
	/**
	 * @var string
	 */
	static public $root;

	/**
	 * @param string $s
	 * 
	 * @return string
	 */
	public static function _new ($s) {
		return $s;
	}

	/**
	 * @param string $this
	 * 
	 * @return bool
	 */
	public static function get_absolute ($this1) {
		return \mb_substr($this1, 0, 1) === "/";
	}

	/**
	 * @param string $this
	 * 
	 * @return bool
	 */
	public static function get_isDir ($this1) {
		$index = mb_strlen($this1) - 1;
		return (($index < 0 ? "" : \mb_substr($this1, $index, 1))) === "/";
	}

	/**
	 * @param string $this
	 * @param string $that
	 * 
	 * @return string
	 */
	public static function join ($this1, $that) {
		if ($that === "") {
			return $this1;
		} else if (\mb_substr($that, 0, 1) === "/") {
			return $that;
		} else {
			$index = mb_strlen($this1) - 1;
			if ((($index < 0 ? "" : \mb_substr($this1, $index, 1))) === "/") {
				return Path_Impl_::ofString(($this1??'null') . ($that??'null'));
			} else {
				$_g = HxString::lastIndexOf($this1, "/");
				if ($_g === -1) {
					return $that;
				} else {
					return Path_Impl_::ofString((\mb_substr($this1, 0, $_g + 1)??'null') . ((($that === null ? "null" : $that))??'null'));
				}
			}
		}
	}

	/**
	 * @param string $s
	 * 
	 * @return string
	 */
	public static function normalize ($s) {
		$s = \trim(\StringTools::replace($s, "\\", "/"));
		if ($s === ".") {
			return "./";
		}
		$isDir = \StringTools::endsWith($s, "/..") || \StringTools::endsWith($s, "/") || \StringTools::endsWith($s, "/.");
		$parts = new \Array_hx();
		$isAbsolute = \StringTools::startsWith($s, "/");
		$up = 0;
		$_g = 0;
		$_g1 = HxString::split($s, "/");
		while ($_g < $_g1->length) {
			$_g2 = \trim(($_g1->arr[$_g++] ?? null));
			if ($_g2 === "") {
			} else if ($_g2 === ".") {
			} else if ($_g2 === "..") {
				if ($parts->length > 0) {
					$parts->length--;
				}
				if (\array_pop($parts->arr) === null) {
					++$up;
				}
			} else {
				$parts->arr[$parts->length++] = $_g2;
			}
		}
		if ($isAbsolute) {
			$parts->length = \array_unshift($parts->arr, "");
		} else {
			$_g = 0;
			$_g1 = $up;
			while ($_g < $_g1) {
				++$_g;
				$parts->length = \array_unshift($parts->arr, "..");
			}
		}
		if ($isDir) {
			$parts->arr[$parts->length++] = "";
		}
		return $parts->join("/");
	}

	/**
	 * @param string $s
	 * 
	 * @return string
	 */
	public static function ofString ($s) {
		return Path_Impl_::normalize($s);
	}

	/**
	 * @param string $this
	 * 
	 * @return \Array_hx
	 */
	public static function parts ($this1) {
		$_g = new \Array_hx();
		$_g1 = 0;
		$_g2 = HxString::split($this1, "/");
		while ($_g1 < $_g2->length) {
			$p = ($_g2->arr[$_g1] ?? null);
			++$_g1;
			if ($p !== "") {
				$_g->arr[$_g->length++] = $p;
			}
		}
		return $_g;
	}

	/**
	 * @param string $this
	 * 
	 * @return string
	 */
	public static function toString ($this1) {
		return $this1;
	}

	/**
	 * @internal
	 * @access private
	 */
	static public function __hx__init ()
	{
		static $called = false;
		if ($called) return;
		$called = true;


		self::$root = "/";
	}
}

Boot::registerClass(Path_Impl_::class, 'tink.url._Path.Path_Impl_');
Boot::registerGetters('tink\\url\\_Path\\Path_Impl_', [
	'isDir' => true,
	'absolute' => true
]);
Path_Impl_::__hx__init();
