<?php
/**
 * Generated by Haxe 4.1.5
 */

use \php\_Boot\HxAnon;
use \php\Boot;
use \haxe\Exception as HaxeException;

/**
 * The EReg class represents regular expressions.
 * While basic usage and patterns consistently work across platforms, some more
 * complex operations may yield different results. This is a necessary trade-
 * off to retain a certain level of performance.
 * EReg instances can be created by calling the constructor, or with the
 * special syntax `~/pattern/modifier`
 * EReg instances maintain an internal state, which is affected by several of
 * its methods.
 * A detailed explanation of the supported operations is available at
 * <https://haxe.org/manual/std-regex.html>
 */
final class EReg {
	/**
	 * @var bool
	 */
	public $global;
	/**
	 * @var string
	 */
	public $last;
	/**
	 * @var mixed
	 */
	public $matches;
	/**
	 * @var string
	 */
	public $options;
	/**
	 * @var string
	 */
	public $pattern;
	/**
	 * @var mixed
	 */
	public $r;
	/**
	 * @var string
	 */
	public $re;

	/**
	 * Escape the string `s` for use as a part of regular expression.
	 * If `s` is null, the result is unspecified.
	 * 
	 * @param string $s
	 * 
	 * @return string
	 */
	public static function escape ($s) {
		return preg_quote($s);
	}

	/**
	 * Creates a new regular expression with pattern `r` and modifiers `opt`.
	 * This is equivalent to the shorthand syntax `~/r/opt`
	 * If `r` or `opt` are null, the result is unspecified.
	 * 
	 * @param string $r
	 * @param string $opt
	 * 
	 * @return void
	 */
	public function __construct ($r, $opt) {
		$this->pattern = $r;
		$this->options = str_replace("g", "", $opt);
		$this->global = $this->options !== $opt;
		$this->options = str_replace("u", "", $this->options);
		$this->re = "\"" . (str_replace("\"", "\\\"", $r)??'null') . "\"" . ($this->options??'null');
	}

	/**
	 * @return string
	 */
	public function get_reUnicode () {
		return ($this->re . "u");
	}

	/**
	 * @return void
	 */
	public function handlePregError () {
		$e = preg_last_error();
		if ($e === PREG_INTERNAL_ERROR) {
			throw HaxeException::thrown("EReg: internal PCRE error");
		} else if ($e === PREG_BACKTRACK_LIMIT_ERROR) {
			throw HaxeException::thrown("EReg: backtrack limit");
		} else if ($e === PREG_RECURSION_LIMIT_ERROR) {
			throw HaxeException::thrown("EReg: recursion limit");
		} else if ($e === PREG_JIT_STACKLIMIT_ERROR) {
			throw HaxeException::thrown("failed due to limited JIT stack space");
		}
	}

	/**
	 * Calls the function `f` for the substring of `s` which `this` EReg matches
	 * and replaces that substring with the result of `f` call.
	 * The `f` function takes `this` EReg object as its first argument and should
	 * return a replacement string for the substring matched.
	 * If `this` EReg does not match any substring, the result is `s`.
	 * By default, this method replaces only the first matched substring. If
	 * the global g modifier is in place, all matched substrings are replaced.
	 * If `s` or `f` are null, the result is unspecified.
	 * 
	 * @param string $s
	 * @param \Closure $f
	 * 
	 * @return string
	 */
	public function map ($s, $f) {
		$p = preg_match(($this->re . "u"), $s, $this->matches, PREG_OFFSET_CAPTURE, 0);
		if ($p === false) {
			$this->handlePregError();
			$p = preg_match($this->re, $s, $this->matches, PREG_OFFSET_CAPTURE);
		}
		if ($p > 0) {
			$this->last = $s;
		} else {
			$this->last = null;
		}
		if ($p <= 0) {
			return $s;
		}
		$result = "";
		$bytesOffset = 0;
		$bytesTotal = strlen($s);
		while (true) {
			$result = ($result??'null') . (substr($s, $bytesOffset, $this->matches[0][1] - $bytesOffset)??'null');
			$result = ($result??'null') . ($f($this)??'null');
			$bytesOffset = $this->matches[0][1];
			if ($this->matches[0][0] === "") {
				$result = ($result??'null') . (mb_substr(substr($s, $bytesOffset), 0, 1)??'null');
				++$bytesOffset;
			} else {
				$bytesOffset += strlen($this->matches[0][0]);
			}
			$tmp = null;
			if ($this->global && ($bytesOffset < $bytesTotal)) {
				$p = preg_match(($this->re . "u"), $s, $this->matches, PREG_OFFSET_CAPTURE, $bytesOffset);
				if ($p === false) {
					$this->handlePregError();
					$p = preg_match($this->re, $s, $this->matches, PREG_OFFSET_CAPTURE);
				}
				if ($p > 0) {
					$this->last = $s;
				} else {
					$this->last = null;
				}
				$tmp = $p > 0;
			} else {
				$tmp = false;
			}
			if (!$tmp) {
				break;
			}
		}
		$result = ($result??'null') . (substr($s, $bytesOffset)??'null');
		return $result;
	}

	/**
	 * Tells if `this` regular expression matches String `s`.
	 * This method modifies the internal state.
	 * If `s` is `null`, the result is unspecified.
	 * 
	 * @param string $s
	 * 
	 * @return bool
	 */
	public function match ($s) {
		$p = preg_match(($this->re . "u"), $s, $this->matches, PREG_OFFSET_CAPTURE, 0);
		if ($p === false) {
			$this->handlePregError();
			$p = preg_match($this->re, $s, $this->matches, PREG_OFFSET_CAPTURE);
		}
		if ($p > 0) {
			$this->last = $s;
		} else {
			$this->last = null;
		}
		return $p > 0;
	}

	/**
	 * @param string $s
	 * @param int $bytesOffset
	 * 
	 * @return bool
	 */
	public function matchFromByte ($s, $bytesOffset) {
		$p = preg_match(($this->re . "u"), $s, $this->matches, PREG_OFFSET_CAPTURE, $bytesOffset);
		if ($p === false) {
			$this->handlePregError();
			$p = preg_match($this->re, $s, $this->matches, PREG_OFFSET_CAPTURE);
		}
		if ($p > 0) {
			$this->last = $s;
		} else {
			$this->last = null;
		}
		return $p > 0;
	}

	/**
	 * Tells if `this` regular expression matches a substring of String `s`.
	 * This function expects `pos` and `len` to describe a valid substring of
	 * `s`, or else the result is unspecified. To get more robust behavior,
	 * `this.match(s.substr(pos,len))` can be used instead.
	 * This method modifies the internal state.
	 * If `s` is null, the result is unspecified.
	 * 
	 * @param string $s
	 * @param int $pos
	 * @param int $len
	 * 
	 * @return bool
	 */
	public function matchSub ($s, $pos, $len = -1) {
		if ($len === null) {
			$len = -1;
		}
		$subject = ($len < 0 ? $s : mb_substr($s, 0, $pos + $len));
		$p = preg_match(($this->re . "u"), $subject, $this->matches, PREG_OFFSET_CAPTURE, $pos);
		if ($p === false) {
			$this->handlePregError();
			$p = preg_match($this->re, $subject, $this->matches, PREG_OFFSET_CAPTURE, $pos);
		}
		if ($p > 0) {
			$this->last = $s;
		} else {
			$this->last = null;
		}
		return $p > 0;
	}

	/**
	 * Returns the matched sub-group `n` of `this` EReg.
	 * This method should only be called after `this.match` or
	 * `this.matchSub`, and then operates on the String of that operation.
	 * The index `n` corresponds to the n-th set of parentheses in the pattern
	 * of `this` EReg. If no such sub-group exists, the result is unspecified.
	 * If `n` equals 0, the whole matched substring is returned.
	 * 
	 * @param int $n
	 * 
	 * @return string
	 */
	public function matched ($n) {
		if (($this->matches === null) || ($n < 0)) {
			throw HaxeException::thrown("EReg::matched");
		}
		if ($n >= count($this->matches)) {
			return null;
		}
		if ($this->matches[$n][1] < 0) {
			return null;
		}
		return $this->matches[$n][0];
	}

	/**
	 * Returns the part to the left of the last matched substring.
	 * If the most recent call to `this.match` or `this.matchSub` did not
	 * match anything, the result is unspecified.
	 * If the global g modifier was in place for the matching, only the
	 * substring to the left of the leftmost match is returned.
	 * The result does not include the matched part.
	 * 
	 * @return string
	 */
	public function matchedLeft () {
		if (count($this->matches) === 0) {
			throw HaxeException::thrown("No string matched");
		}
		return substr($this->last, 0, $this->matches[0][1]);
	}

	/**
	 * Returns the position and length of the last matched substring, within
	 * the String which was last used as argument to `this.match` or
	 * `this.matchSub`.
	 * If the most recent call to `this.match` or `this.matchSub` did not
	 * match anything, the result is unspecified.
	 * If the global g modifier was in place for the matching, the position and
	 * length of the leftmost substring is returned.
	 * 
	 * @return object
	 */
	public function matchedPos () {
		$tmp = mb_strlen(substr($this->last, 0, $this->matches[0][1]));
		return new HxAnon([
			"pos" => $tmp,
			"len" => mb_strlen($this->matches[0][0]),
		]);
	}

	/**
	 * Returns the part to the right of the last matched substring.
	 * If the most recent call to `this.match` or `this.matchSub` did not
	 * match anything, the result is unspecified.
	 * If the global g modifier was in place for the matching, only the
	 * substring to the right of the leftmost match is returned.
	 * The result does not include the matched part.
	 * 
	 * @return string
	 */
	public function matchedRight () {
		if (count($this->matches) === 0) {
			throw HaxeException::thrown("No string matched");
		}
		$x = $this->matches[0][1] + strlen($this->matches[0][0]);
		return substr($this->last, $x);
	}

	/**
	 * Replaces the first substring of `s` which `this` EReg matches with `by`.
	 * If `this` EReg does not match any substring, the result is `s`.
	 * By default, this method replaces only the first matched substring. If
	 * the global g modifier is in place, all matched substrings are replaced.
	 * If `by` contains `$1` to `$9`, the digit corresponds to number of a
	 * matched sub-group and its value is used instead. If no such sub-group
	 * exists, the replacement is unspecified. The string `$$` becomes `$`.
	 * If `s` or `by` are null, the result is unspecified.
	 * 
	 * @param string $s
	 * @param string $by
	 * 
	 * @return string
	 */
	public function replace ($s, $by) {
		$by = str_replace("\\\$", "\\\\\$", $by);
		$by = str_replace("\$\$", "\\\$", $by);
		if (!preg_match("/\\\\([^?].*?\\\\)/", $this->re)) {
			$by = preg_replace("/\\\$(\\d+)/", "\\\$\\1", $by);
		}
		$result = preg_replace(($this->re . "u"), $by, $s, ($this->global ? -1 : 1));
		if ($result === null) {
			$this->handlePregError();
			$result = preg_replace($this->re, $by, $s, ($this->global ? -1 : 1));
		}
		return $result;
	}

	/**
	 * Splits String `s` at all substrings `this` EReg matches.
	 * If a match is found at the start of `s`, the result contains a leading
	 * empty String "" entry.
	 * If a match is found at the end of `s`, the result contains a trailing
	 * empty String "" entry.
	 * If two matching substrings appear next to each other, the result
	 * contains the empty String `""` between them.
	 * By default, this method splits `s` into two parts at the first matched
	 * substring. If the global g modifier is in place, `s` is split at each
	 * matched substring.
	 * If `s` is null, the result is unspecified.
	 * 
	 * @param string $s
	 * 
	 * @return \Array_hx
	 */
	public function split ($s) {
		$parts = preg_split(($this->re . "u"), $s, ($this->global ? -1 : 2));
		if ($parts === null) {
			$this->handlePregError();
			$parts = preg_split($this->re, $s, ($this->global ? -1 : 2));
		}
		return \Array_hx::wrap($parts);
	}
}

Boot::registerClass(EReg::class, 'EReg');
Boot::registerGetters('EReg', [
	'reUnicode' => true
]);
