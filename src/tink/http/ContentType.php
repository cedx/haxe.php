<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace tink\http;

use \php\Boot;
use \php\_Boot\HxString;
use \tink\http\_Header\HeaderValue_Impl_;
use \haxe\ds\StringMap;

class ContentType {
	/**
	 * @var StringMap
	 */
	public $extensions;
	/**
	 * @var string
	 */
	public $raw;
	/**
	 * @var string
	 */
	public $subtype;
	/**
	 * @var string
	 */
	public $type;

	/**
	 * @param string $s
	 * 
	 * @return ContentType
	 */
	public static function ofString ($s) {
		$ret = new ContentType();
		$ret->raw = $s;
		$parsed = HeaderValue_Impl_::parse($s);
		$value = ($parsed->arr[0] ?? null)->value;
		$_g = HxString::indexOf($value, "/");
		if ($_g === -1) {
			$ret->type = $value;
		} else {
			$ret->type = HxString::substring($value, 0, $_g);
			$ret->subtype = HxString::substring($value, $_g + 1);
		}
		$ret->extensions = ($parsed->arr[0] ?? null)->extensions;
		return $ret;
	}

	/**
	 * @return void
	 */
	public function __construct () {
		$this->subtype = "*";
		$this->type = "*";
		$this->extensions = new StringMap();
	}

	/**
	 * @return string
	 */
	public function get_fullType () {
		return "" . ($this->type??'null') . "/" . ($this->subtype??'null');
	}

	/**
	 * @return string
	 */
	public function toString () {
		return $this->raw;
	}

	public function __toString() {
		return $this->toString();
	}
}

Boot::registerClass(ContentType::class, 'tink.http.ContentType');
Boot::registerGetters('tink\\http\\ContentType', [
	'fullType' => true
]);
