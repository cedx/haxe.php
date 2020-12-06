<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace tink\http\_Header;

use \php\_Boot\HxAnon;
use \haxe\io\_BytesData\Container;
use \php\Boot;
use \tink\url\_Query\QueryStringParser;
use \php\_Boot\HxString;
use \haxe\ds\StringMap;
use \haxe\io\Bytes;
use \tink\url\_Portion\Portion_Impl_;

final class HeaderValue_Impl_ {
	/**
	 * @var \Array_hx
	 */
	static public $DAYS;
	/**
	 * @var \Array_hx
	 */
	static public $MONTHS;

	/**
	 * @param string $username
	 * @param string $password
	 * 
	 * @return string
	 */
	public static function basicAuth ($username, $password) {
		$s = "" . ($username??'null') . ":" . ($password??'null');
		$bytes = \strlen($s);
		return "Basic " . (\base64_encode((new Bytes($bytes, new Container($s)))->toString())??'null');
	}

	/**
	 * @param string $this
	 * 
	 * @return StringMap
	 */
	public static function getExtension ($this1) {
		return (HeaderValue_Impl_::parse($this1)->arr[0] ?? null)->extensions;
	}

	/**
	 * @param \Date $d
	 * 
	 * @return string
	 */
	public static function ofDate ($d) {
		return \DateTools::format($d, ((HeaderValue_Impl_::$DAYS->arr[$d->getDay()] ?? null)??'null') . ", %d " . ((HeaderValue_Impl_::$MONTHS->arr[$d->getMonth()] ?? null)??'null') . " %Y %H:%M:%S GMT");
	}

	/**
	 * @param int $i
	 * 
	 * @return string
	 */
	public static function ofInt ($i) {
		return \Std::string($i);
	}

	/**
	 *  Parse the value of this header in to `{value:String, extensions:Map<String, String>}` form
	 * 
	 * @param string $this
	 * 
	 * @return \Array_hx
	 */
	public static function parse ($this1) {
		return HeaderValue_Impl_::parseWith($this1, function ($_, $params) {
			$_g = new StringMap();
			while ($params->hasNext()) {
				$p = $params->next();
				$key = $p->name;
				$_g1 = Portion_Impl_::toString($p->value);
				$value = (HxString::charCodeAt($_g1, 0) === 34 ? \mb_substr($_g1, 1, mb_strlen($_g1) - 2) : $_g1);
				$_g->data[$key] = $value;
			}
			return $_g;
		});
	}

	/**
	 *  Parse the value of this header, using the given function to parse the extensions
	 *  @param parseExtension - function to parse the extension
	 * 
	 * @param string $this
	 * @param \Closure $parseExtension
	 * 
	 * @return \Array_hx
	 */
	public static function parseWith ($this1, $parseExtension) {
		$_g = new \Array_hx();
		$_g1 = 0;
		$_g2 = HxString::split($this1, ",");
		while ($_g1 < $_g2->length) {
			$v = ($_g2->arr[$_g1] ?? null);
			++$_g1;
			$v = \trim($v);
			$_g3 = HxString::indexOf($v, ";");
			$i = ($_g3 === -1 ? mb_strlen($v) : $_g3);
			$value = \mb_substr($v, 0, $i);
			$pos = $i + 1;
			if ($pos === null) {
				$pos = 0;
			}
			$x = new HxAnon([
				"value" => $value,
				"extensions" => $parseExtension($value, new QueryStringParser($v, ";", "=", $pos)),
			]);
			$_g->arr[$_g->length++] = $x;
		}
		return $_g;
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


		self::$DAYS = HxString::split("Sun,Mon,Tue,Wen,Thu,Fri,Sat", ",");
		self::$MONTHS = HxString::split("Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,Oct,Nov,Dec", ",");
	}
}

Boot::registerClass(HeaderValue_Impl_::class, 'tink.http._Header.HeaderValue_Impl_');
HeaderValue_Impl_::__hx__init();