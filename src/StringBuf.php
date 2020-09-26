<?php
/**
 * Generated by Haxe 4.1.4
 */

use \php\Boot;

/**
 * A String buffer is an efficient way to build a big string by appending small
 * elements together.
 * Unlike String, an instance of StringBuf is not immutable in the sense that
 * it can be passed as argument to functions which modify it by appending more
 * values.
 */
class StringBuf {
	/**
	 * @var string
	 */
	public $b;

	/**
	 * Creates a new StringBuf instance.
	 * This may involve initialization of the internal buffer.
	 * 
	 * @return void
	 */
	public function __construct () {
		$this->b = "";
	}

	/**
	 * Appends the representation of `x` to `this` StringBuf.
	 * The exact representation of `x` may vary per platform. To get more
	 * consistent behavior, this function should be called with
	 * Std.string(x).
	 * If `x` is null, the String "null" is appended.
	 * 
	 * @param mixed $x
	 * 
	 * @return void
	 */
	public function add ($x) {
		if ($x === null) {
			$this->b = ($this->b . "null");
		} else if (is_bool($x)) {
			$this->b = ($this->b . ($x ? "true" : "false"));
		} else if (is_string($x)) {
			$this->b = ($this->b . $x);
		} else {
			$tmp = $this;
			$tmp->b = ($tmp->b??'null') . (\Std::string($x)??'null');
		}
	}

	/**
	 * Appends the character identified by `c` to `this` StringBuf.
	 * If `c` is negative or has another invalid value, the result is
	 * unspecified.
	 * 
	 * @param int $c
	 * 
	 * @return void
	 */
	public function addChar ($c) {
		$tmp = $this;
		$tmp->b = ($tmp->b??'null') . (mb_chr($c)??'null');
	}

	/**
	 * Appends a substring of `s` to `this` StringBuf.
	 * This function expects `pos` and `len` to describe a valid substring of
	 * `s`, or else the result is unspecified. To get more robust behavior,
	 * `this.add(s.substr(pos,len))` can be used instead.
	 * If `s` or `pos` are null, the result is unspecified.
	 * If `len` is omitted or null, the substring ranges from `pos` to the end
	 * of `s`.
	 * 
	 * @param string $s
	 * @param int $pos
	 * @param int $len
	 * 
	 * @return void
	 */
	public function addSub ($s, $pos, $len = null) {
		$tmp = $this;
		$tmp->b = ($tmp->b??'null') . (mb_substr($s, $pos, $len)??'null');
	}

	/**
	 * @return int
	 */
	public function get_length () {
		return mb_strlen($this->b);
	}

	/**
	 * Returns the content of `this` StringBuf as String.
	 * The buffer is not emptied by this operation.
	 * 
	 * @return string
	 */
	public function toString () {
		return $this->b;
	}

	public function __toString() {
		return $this->toString();
	}
}

Boot::registerClass(StringBuf::class, 'StringBuf');
Boot::registerGetters('StringBuf', [
	'length' => true
]);
