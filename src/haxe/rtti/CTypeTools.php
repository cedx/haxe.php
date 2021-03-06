<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace haxe\rtti;

use \php\Boot;

/**
 * The `CTypeTools` class contains some extra functionalities for handling
 * `CType` instances.
 */
class CTypeTools {
	/**
	 * @param object $cf
	 * 
	 * @return string
	 */
	public static function classField ($cf) {
		return ($cf->name??'null') . ":" . (CTypeTools::toString($cf->type)??'null');
	}

	/**
	 * @param object $arg
	 * 
	 * @return string
	 */
	public static function functionArgumentName ($arg) {
		return ((($arg->opt ? "?" : ""))??'null') . ((($arg->name === "" ? "" : ($arg->name??'null') . ":"))??'null') . (CTypeTools::toString($arg->t)??'null') . ((($arg->value === null ? "" : " = " . ($arg->value??'null')))??'null');
	}

	/**
	 * @param string $name
	 * @param \Array_hx $params
	 * 
	 * @return string
	 */
	public static function nameWithParams ($name, $params) {
		if ($params->length === 0) {
			return $name;
		}
		$tmp = ($name??'null') . "<";
		$f = Boot::getStaticClosure(CTypeTools::class, 'toString');
		$result = [];
		$data = $params->arr;
		$_g_current = 0;
		$_g_length = \count($data);
		while ($_g_current < $_g_length) {
			$result[] = $f($data[$_g_current++]);
		}
		return ($tmp??'null') . (\Array_hx::wrap($result)->join(", ")??'null') . ">";
	}

	/**
	 * Get the string representation of `CType`.
	 * 
	 * @param CType $t
	 * 
	 * @return string
	 */
	public static function toString ($t) {
		$__hx__switch = ($t->index);
		if ($__hx__switch === 0) {
			return "unknown";
		} else if ($__hx__switch === 1) {
			return CTypeTools::nameWithParams($t->params[0], $t->params[1]);
		} else if ($__hx__switch === 2) {
			return CTypeTools::nameWithParams($t->params[0], $t->params[1]);
		} else if ($__hx__switch === 3) {
			return CTypeTools::nameWithParams($t->params[0], $t->params[1]);
		} else if ($__hx__switch === 4) {
			$_g = $t->params[1];
			$_g1 = $t->params[0];
			if ($_g1->length === 0) {
				return "Void -> " . (CTypeTools::toString($_g)??'null');
			} else {
				$f = Boot::getStaticClosure(CTypeTools::class, 'functionArgumentName');
				$result = [];
				$data = $_g1->arr;
				$_g_current = 0;
				$_g_length = \count($data);
				while ($_g_current < $_g_length) {
					$result[] = $f($data[$_g_current++]);
				}
				return (\Array_hx::wrap($result)->join(" -> ")??'null') . " -> " . (CTypeTools::toString($_g)??'null');
			}
		} else if ($__hx__switch === 5) {
			$f = Boot::getStaticClosure(CTypeTools::class, 'classField');
			$result = [];
			$data = $t->params[0]->arr;
			$_g_current = 0;
			$_g_length = \count($data);
			while ($_g_current < $_g_length) {
				$result[] = $f($data[$_g_current++]);
			}
			return "{ " . (\Array_hx::wrap($result)->join(", ")??'null') . "}";
		} else if ($__hx__switch === 6) {
			$_g = $t->params[0];
			if ($_g === null) {
				return "Dynamic";
			} else {
				return "Dynamic<" . (CTypeTools::toString($_g)??'null') . ">";
			}
		} else if ($__hx__switch === 7) {
			return CTypeTools::nameWithParams($t->params[0], $t->params[1]);
		}
	}
}

Boot::registerClass(CTypeTools::class, 'haxe.rtti.CTypeTools');
