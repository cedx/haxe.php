<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace tink\parse;

use \php\_Boot\HxAnon;
use \php\Boot;
use \haxe\Exception;
use \tink\core\TypedError;
use \tink\core\Outcome;
use \tink\core\OutcomeTools;
use \tink\parse\_StringSlice\Data;
use \tink\parse\_StringSlice\StringSlice_Impl_;
use \haxe\ds\_Vector\PhpVectorData;

class ParserBase {
	/**
	 * @var int
	 */
	public $lastSkip;
	/**
	 * @var int
	 */
	public $max;
	/**
	 * @var int
	 */
	public $offset;
	/**
	 * @var int
	 */
	public $pos;
	/**
	 * @var ReporterObject
	 */
	public $reporter;
	/**
	 * @var Data
	 */
	public $source;

	/**
	 * @param Data $source
	 * @param ReporterObject $reporter
	 * @param int $offset
	 * 
	 * @return void
	 */
	public function __construct ($source, $reporter, $offset = 0) {
		if ($offset === null) {
			$offset = 0;
		}
		$this->source = $source;
		$this->max = $source->length;
		$this->pos = 0;
		$this->reporter = $reporter;
		$this->offset = $offset;
	}

	/**
	 * skip ignored characters, then match the specified string, and consume it if matched
	 * 
	 * @param Data $s
	 * 
	 * @return bool
	 */
	public function allow ($s) {
		$this->skipIgnored();
		return $this->allowHere($s);
	}

	/**
	 * match the specified string, and consume it if matched
	 * 
	 * @param Data $s
	 * 
	 * @return bool
	 */
	public function allowHere ($s) {
		if (StringSlice_Impl_::hasSub($this->source, $s, $this->pos)) {
			$this->pos += $s->length;
			return true;
		} else {
			return false;
		}
	}

	/**
	 * produce an outcome and rewind only in case of failure
	 * 
	 * @param \Closure $s
	 * 
	 * @return Outcome
	 */
	public function attempt ($s) {
		$start = $this->pos;
		$ret = $s();
		if (!OutcomeTools::isSuccess($ret)) {
			$this->pos = $start;
		}
		return $ret;
	}

	/**
	 * @param int $start
	 * @param int $offset
	 * 
	 * @return Data
	 */
	public function chomp ($start, $offset = 0) {
		if ($offset === null) {
			$offset = 0;
		}
		$this1 = $this->source;
		return StringSlice_Impl_::_new($this1->string, StringSlice_Impl_::wrap($this1, $start) + $this1->start, StringSlice_Impl_::clamp($this1, $this->pos + $offset) + $this1->start);
	}

	/**
	 * return current character, without consuming it
	 * 
	 * @return int
	 */
	public function current () {
		$this1 = $this->source;
		return \StringTools::fastCodeAt($this1->string, $this->pos + $this1->start);
	}

	/**
	 * throw an error, optionally include a position (default at current character)
	 * 
	 * @param string $message
	 * @param \IntIterator $range
	 * 
	 * @return mixed
	 */
	public function die ($message, $range = null) {
		if ($range === null) {
			$range = new \IntIterator($this->pos, $this->pos + 1);
		}
		$from = $range->min;
		$to = $range->max;
		$pos = $this->reporter->makePos($this->offset + $from, $this->offset + (($to === null ? $from + 1 : $to)));
		throw Exception::thrown($this->reporter->makeError($message, $pos));
	}

	/**
	 * advance while character fulfills the specified condition
	 * 
	 * @param PhpVectorData $cond
	 * 
	 * @return void
	 */
	public function doReadWhile ($cond) {
		while (true) {
			$tmp = null;
			if ($this->pos < $this->max) {
				$this1 = $this->source;
				$char = \StringTools::fastCodeAt($this1->string, $this->pos + $this1->start);
				$tmp = ($cond->data[$char] ?? null);
			} else {
				$tmp = false;
			}
			if (!$tmp) {
				break;
			}
			$this->pos++;
		}
	}

	/**
	 * @return void
	 */
	public function doSkipIgnored () {
	}

	/**
	 * skip ignored characters and check if reached the end
	 * 
	 * @return bool
	 */
	public function done () {
		$this->skipIgnored();
		return $this->pos >= $this->max;
	}

	/**
	 * skip ignored characters, then match the specified string, and throw if doesn't match
	 * use with operator `+` to produce a value
	 * 
	 * @param Data $s
	 * 
	 * @return mixed
	 */
	public function expect ($s) {
		if (!$this->allow($s)) {
			$this->die("expected " . ((($s === null ? "null" : $s->toString()))??'null'));
		}
		return null;
	}

	/**
	 * match the specified string, and throw if doesn't match
	 * use with operator `+` to produce a value
	 * 
	 * @param Data $s
	 * 
	 * @return mixed
	 */
	public function expectHere ($s) {
		if (!$this->allowHere($s)) {
			$this->die("expected " . ((($s === null ? "null" : $s->toString()))??'null'));
		}
		return null;
	}

	/**
	 * @param \Array_hx $a
	 * @param \Closure $before
	 * 
	 * @return Outcome
	 */
	public function first ($a, $before) {
		$message = "Failed to find either of " . ($a->join(",")??'null');
		$from = $this->pos;
		$to = $this->pos;
		$pos = $this->reporter->makePos($this->offset + $from, $this->offset + (($to === null ? $from + 1 : $to)));
		$ret = Outcome::Failure($this->reporter->makeError($message, $pos));
		$min = $this->max;
		$_g = 0;
		while ($_g < $a->length) {
			$s = ($a->arr[$_g] ?? null);
			++$_g;
			$_g1 = StringSlice_Impl_::indexOf($this->source, StringSlice_Impl_::ofString($s), $this->pos);
			if ($_g1 !== -1) {
				if ($_g1 < $min) {
					$min = $_g1;
					$ret = Outcome::Success($s);
				}
			}
		}
		if ($ret->index === 0) {
			$this1 = $this->source;
			$before(StringSlice_Impl_::_new($this1->string, StringSlice_Impl_::wrap($this1, $this->pos) + $this1->start, StringSlice_Impl_::clamp($this1, $min) + $this1->start));
			$this->pos = $min + mb_strlen($ret->params[0]);
		}
		return $ret;
	}

	/**
	 * check if current character matches the specified condition, without consuming it
	 * 
	 * @param PhpVectorData $cond
	 * 
	 * @return bool
	 */
	public function is ($cond) {
		if ($this->pos < $this->max) {
			$this1 = $this->source;
			$char = \StringTools::fastCodeAt($this1->string, $this->pos + $this1->start);
			return ($cond->data[$char] ?? null);
		} else {
			return false;
		}
	}

	/**
	 * check if current position matches the specifed string, without consuming it
	 * 
	 * @param Data $s
	 * 
	 * @return bool
	 */
	public function isNext ($s) {
		return StringSlice_Impl_::hasSub($this->source, $s, $this->pos);
	}

	/**
	 * skip the specified number of characters
	 * 
	 * @param int $count
	 * 
	 * @return void
	 */
	public function junk ($count = 1) {
		if ($count === null) {
			$count = 1;
		}
		$this->pos += $count;
		if ($this->pos > $this->max) {
			$this->pos = $this->max;
		}
	}

	/**
	 * produce a value and include its position
	 * 
	 * @param \Closure $f
	 * 
	 * @return object
	 */
	public function located ($f) {
		$start = $this->pos;
		$tmp = $f();
		$to = $this->pos;
		return new HxAnon([
			"value" => $tmp,
			"pos" => $this->reporter->makePos($this->offset + $start, $this->offset + (($to === null ? $start + 1 : $to))),
		]);
	}

	/**
	 * produce a value and then rewind position (note: throw in the generator function to abort)
	 * 
	 * @param \Closure $fn
	 * 
	 * @return mixed
	 */
	public function lookahead ($fn) {
		$_gthis = $this;
		$start = $this->pos;
		return TypedError::tryFinally($fn, function () use (&$start, &$_gthis) {
			$_gthis->pos = $start;
		});
	}

	/**
	 * @param string $message
	 * @param mixed $pos
	 * 
	 * @return mixed
	 */
	public function makeError ($message, $pos) {
		return $this->reporter->makeError($message, $pos);
	}

	/**
	 * @param int $from
	 * @param int $to
	 * 
	 * @return mixed
	 */
	public function makePos ($from, $to = null) {
		return $this->reporter->makePos($this->offset + $from, $this->offset + (($to === null ? $from + 1 : $to)));
	}

	/**
	 * @param \Closure $reader
	 * @param object $settings
	 * 
	 * @return \Array_hx
	 */
	public function parseList ($reader, $settings) {
		$ret = new \Array_hx();
		$this->parseRepeatedly(function () use (&$ret, &$reader) {
			$x = $reader();
			$ret->arr[$ret->length++] = $x;
		}, $settings);
		return $ret;
	}

	/**
	 * @param \Closure $reader
	 * @param object $settings
	 * 
	 * @return void
	 */
	public function parseRepeatedly ($reader, $settings) {
		if (($settings->start !== null) && !$this->allow($settings->start)) {
			return;
		}
		$_g = $settings->sep;
		if ($_g === null) {
			while (!$this->allow($settings->end)) {
				$reader();
			}
		} else {
			if ($this->allow($settings->end)) {
				return;
			}
			while (true) {
				$reader();
				$_g1 = $settings->trailing;
				if ($_g1 === null) {
					$hasSep = $this->allow($_g);
					if ($this->allow($settings->end)) {
						return;
					}
					if (!$hasSep) {
						$this->die("expected " . ((($_g === null ? "null" : $_g->toString()))??'null') . " or " . ((($settings->end === null ? "null" : $settings->end->toString()))??'null'));
					}
				} else {
					if ($_g1 === "Always") {
						$this->expect($_g);
						if ($this->allow($settings->end)) {
							return;
						}
					} else if ($_g1 === "Never") {
						if ($this->allow($settings->end)) {
							return;
						}
						$this->expect($_g);
					}
				}
			}
		}
	}

	/**
	 * @param \Closure $reader
	 * 
	 * @return object
	 */
	public function read ($reader) {
		$this->skipIgnored();
		$start = $this->pos;
		$ret = $reader();
		$to = $this->pos;
		$tmp = $this->reporter->makePos($this->offset + $start, $this->offset + (($to === null ? $start + 1 : $to)));
		return new HxAnon([
			"data" => $ret,
			"pos" => $tmp,
			"bytesRead" => $this->pos - $start,
		]);
	}

	/**
	 * skip ignored characters, then advance while character fulfills the specified condition, and return the scanned string
	 * 
	 * @param PhpVectorData $cond
	 * 
	 * @return Data
	 */
	public function readWhile ($cond) {
		$this->skipIgnored();
		$start = $this->pos;
		while (true) {
			$tmp = null;
			if ($this->pos < $this->max) {
				$this1 = $this->source;
				$char = \StringTools::fastCodeAt($this1->string, $this->pos + $this1->start);
				$tmp = ($cond->data[$char] ?? null);
			} else {
				$tmp = false;
			}
			if (!$tmp) {
				break;
			}
			$this->pos++;
		}
		$this1 = $this->source;
		return StringSlice_Impl_::_new($this1->string, StringSlice_Impl_::wrap($this1, $start) + $this1->start, StringSlice_Impl_::clamp($this1, $this->pos) + $this1->start);
	}

	/**
	 * @param Data $s
	 * @param string $reason
	 * 
	 * @return mixed
	 */
	public function reject ($s, $reason = null) {
		if ($reason === null) {
			return $this->reject(StringSlice_Impl_::ofString("unexpected " . ((($s === null ? "null" : $s->toString()))??'null')));
		} else {
			$from = $s->start;
			$to = $s->end;
			$pos = $this->reporter->makePos($this->offset + $from, $this->offset + (($to === null ? $from + 1 : $to)));
			throw Exception::thrown($this->reporter->makeError($reason, $pos));
		}
	}

	/**
	 * skip ignored values
	 * 
	 * @return mixed
	 */
	public function skipIgnored () {
		while ($this->lastSkip !== $this->pos) {
			$this->lastSkip = $this->pos;
			$this->doSkipIgnored();
		}
		$this->lastSkip = $this->pos;
		return null;
	}

	/**
	 * skip ignored characters, then match the character against the specified condition, without consuming it
	 * 
	 * @param PhpVectorData $cond
	 * 
	 * @return bool
	 */
	public function upNext ($cond) {
		$this->skipIgnored();
		if ($this->pos < $this->max) {
			$this1 = $this->source;
			$char = \StringTools::fastCodeAt($this1->string, $this->pos + $this1->start);
			return ($cond->data[$char] ?? null);
		} else {
			return false;
		}
	}

	/**
	 * consume and return string upto `end`, set `addEnd = true` to include `end` itself
	 * 
	 * @param Data $end
	 * @param bool $addEnd
	 * 
	 * @return Outcome
	 */
	public function upto ($end, $addEnd = null) {
		$_g = StringSlice_Impl_::indexOf($this->source, $end, $this->pos);
		if ($_g === -1) {
			$message = ($end === null ? "null" : $end->toString());
			$from = $this->pos;
			$pos = $this->reporter->makePos($this->offset + $from, $this->offset + ($from + 1));
			return Outcome::Failure($this->reporter->makeError("expected " . ($message??'null'), $pos));
		} else {
			$this1 = $this->source;
			$ret = StringSlice_Impl_::_new($this1->string, StringSlice_Impl_::wrap($this1, $this->pos) + $this1->start, StringSlice_Impl_::clamp($this1, $_g + (($addEnd ? $end->length : 0))) + $this1->start);
			$this->pos = $_g + $end->length;
			return Outcome::Success($ret);
		}
	}
}

Boot::registerClass(ParserBase::class, 'tink.parse.ParserBase');