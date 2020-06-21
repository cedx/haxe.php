<?php
/**
 * Generated by Haxe 4.1.2
 */

namespace haxe;

use \php\Boot;
use \php\_Boot\HxString;

/**
 * Do not use manually.
 */
class NativeStackTrace {
	/**
	 * @var mixed
	 */
	static public $lastExceptionTrace;
	/**
	 * @var \Closure
	 * If defined this function will be used to transform call stack entries.
	 * @param String - generated php file name.
	 * @param Int - Line number in generated file.
	 */
	static public $mapPosition;

	/**
	 * @return mixed
	 */
	public static function callStack () {
		return debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
	}

	/**
	 * @param mixed $nativeTrace
	 * @param \Throwable $e
	 * 
	 * @return mixed
	 */
	public static function complementTrace ($nativeTrace, $e) {
		$thrownAt = [];
		$thrownAt["function"] = "";
		$thrownAt["line"] = $e->getLine();
		$thrownAt["file"] = $e->getFile();
		$thrownAt["class"] = "";
		$thrownAt["args"] = [];
		array_unshift($nativeTrace, $thrownAt);
		return $nativeTrace;
	}

	/**
	 * @return mixed
	 */
	public static function exceptionStack () {
		if (NativeStackTrace::$lastExceptionTrace === null) {
			return [];
		} else {
			return NativeStackTrace::$lastExceptionTrace;
		}
	}

	/**
	 * @param \Throwable $e
	 * 
	 * @return void
	 */
	public static function saveStack ($e) {
		$nativeTrace = $e->getTrace();
		$currentTrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
		$_g = -(count($currentTrace) - 1);
		while ($_g < 1) {
			$i = $_g++;
			$exceptionEntry = end($nativeTrace);
			if (!isset($exceptionEntry["file"]) || !isset($currentTrace[-$i]["file"])) {
				array_pop($nativeTrace);
			} else if (Boot::equal($currentTrace[-$i]["file"], $exceptionEntry["file"]) && Boot::equal($currentTrace[-$i]["line"], $exceptionEntry["line"])) {
				array_pop($nativeTrace);
			} else {
				break;
			}
		}
		$count = count($nativeTrace);
		$_g = 0;
		while ($_g < $count) {
			$this1 = [];
			$nativeTrace[$_g++]["args"] = $this1;
		}
		NativeStackTrace::$lastExceptionTrace = NativeStackTrace::complementTrace($nativeTrace, $e);
	}

	/**
	 * @param mixed $native
	 * @param int $skip
	 * 
	 * @return \Array_hx
	 */
	public static function toHaxe ($native, $skip = 0) {
		if ($skip === null) {
			$skip = 0;
		}
		$result = new \Array_hx();
		$count = count($native);
		$_g = 0;
		while ($_g < $count) {
			$i = $_g++;
			if ($skip > $i) {
				continue;
			}
			$entry = $native[$i];
			$item = null;
			if (($i + 1) < $count) {
				$next = $native[$i + 1];
				if (!isset($next["function"])) {
					$next["function"] = "";
				}
				if (!isset($next["class"])) {
					$next["class"] = "";
				}
				if (HxString::indexOf($next["function"], "{closure}") >= 0) {
					$item = StackItem::LocalFunction();
				} else if ((strlen($next["class"]) > 0) && (strlen($next["function"]) > 0)) {
					$cls = Boot::getClassName($next["class"]);
					$item = StackItem::Method($cls, $next["function"]);
				}
			}
			if (isset($entry["file"])) {
				if (NativeStackTrace::$mapPosition !== null) {
					$pos = (NativeStackTrace::$mapPosition)($entry["file"], $entry["line"]);
					if (($pos !== null) && ($pos->source !== null) && ($pos->originalLine !== null)) {
						$entry["file"] = $pos->source;
						$entry["line"] = $pos->originalLine;
					}
				}
				$x = StackItem::FilePos($item, $entry["file"], $entry["line"]);
				$result->arr[$result->length++] = $x;
			} else if ($item !== null) {
				$result->arr[$result->length++] = $item;
			}
		}
		return $result;
	}
}

Boot::registerClass(NativeStackTrace::class, 'haxe.NativeStackTrace');
