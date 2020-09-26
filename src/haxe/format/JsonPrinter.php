<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace haxe\format;

use \php\_Boot\HxAnon;
use \php\Boot;
use \php\_Boot\HxClosure;
use \haxe\ds\StringMap;

/**
 * An implementation of JSON printer in Haxe.
 * This class is used by `haxe.Json` when native JSON implementation
 * is not available.
 * @see https://haxe.org/manual/std-Json-encoding.html
 */
class JsonPrinter {
	/**
	 * @var \StringBuf
	 */
	public $buf;
	/**
	 * @var string
	 */
	public $indent;
	/**
	 * @var int
	 */
	public $nind;
	/**
	 * @var bool
	 */
	public $pretty;
	/**
	 * @var \Closure
	 */
	public $replacer;

	/**
	 * Encodes `o`'s value and returns the resulting JSON string.
	 * If `replacer` is given and is not null, it is used to retrieve
	 * actual object to be encoded. The `replacer` function takes two parameters,
	 * the key and the value being encoded. Initial key value is an empty string.
	 * If `space` is given and is not null, the result will be pretty-printed.
	 * Successive levels will be indented by this string.
	 * 
	 * @param mixed $o
	 * @param \Closure $replacer
	 * @param string $space
	 * 
	 * @return string
	 */
	public static function print ($o, $replacer = null, $space = null) {
		$printer = new JsonPrinter($replacer, $space);
		$printer->write("", $o);
		return $printer->buf->b;
	}

	/**
	 * @param \Closure $replacer
	 * @param string $space
	 * 
	 * @return void
	 */
	public function __construct ($replacer, $space) {
		$this->replacer = $replacer;
		$this->indent = $space;
		$this->pretty = $space !== null;
		$this->nind = 0;
		$this->buf = new \StringBuf();
	}

	/**
	 * @param mixed $v
	 * 
	 * @return void
	 */
	public function classString ($v) {
		$this->fieldsString($v, \Type::getInstanceFields(\Type::getClass($v)));
	}

	/**
	 * @param mixed $v
	 * @param \Array_hx $fields
	 * 
	 * @return void
	 */
	public function fieldsString ($v, $fields) {
		$_this = $this->buf;
		$_this->b = ($_this->b??'null') . (\mb_chr(123)??'null');
		$len = $fields->length;
		$last = $len - 1;
		$first = true;
		$_g = 0;
		while ($_g < $len) {
			$i = $_g++;
			$f = ($fields->arr[$i] ?? null);
			$value = \Reflect::field($v, $f);
			if (($value instanceof \Closure) || ($value instanceof HxClosure)) {
				continue;
			}
			if ($first) {
				$this->nind++;
				$first = false;
			} else {
				$_this = $this->buf;
				$_this->b = ($_this->b??'null') . (\mb_chr(44)??'null');
			}
			if ($this->pretty) {
				$_this1 = $this->buf;
				$_this1->b = ($_this1->b??'null') . (\mb_chr(10)??'null');
			}
			if ($this->pretty) {
				$v1 = \StringTools::lpad("", $this->indent, $this->nind * mb_strlen($this->indent));
				$this->buf->add($v1);
			}
			$this->quote($f);
			$_this2 = $this->buf;
			$_this2->b = ($_this2->b??'null') . (\mb_chr(58)??'null');
			if ($this->pretty) {
				$_this3 = $this->buf;
				$_this3->b = ($_this3->b??'null') . (\mb_chr(32)??'null');
			}
			$this->write($f, $value);
			if ($i === $last) {
				$this->nind--;
				if ($this->pretty) {
					$_this4 = $this->buf;
					$_this4->b = ($_this4->b??'null') . (\mb_chr(10)??'null');
				}
				if ($this->pretty) {
					$v2 = \StringTools::lpad("", $this->indent, $this->nind * mb_strlen($this->indent));
					$this->buf->add($v2);
				}
			}
		}
		$_this = $this->buf;
		$_this->b = ($_this->b??'null') . (\mb_chr(125)??'null');
	}

	/**
	 * @return void
	 */
	public function ipad () {
		if ($this->pretty) {
			$v = \StringTools::lpad("", $this->indent, $this->nind * mb_strlen($this->indent));
			$this->buf->add($v);
		}
	}

	/**
	 * @return void
	 */
	public function newl () {
		if ($this->pretty) {
			$_this = $this->buf;
			$_this->b = ($_this->b??'null') . (\mb_chr(10)??'null');
		}
	}

	/**
	 * @param mixed $v
	 * 
	 * @return void
	 */
	public function objString ($v) {
		$this->fieldsString($v, \Reflect::fields($v));
	}

	/**
	 * @param string $s
	 * 
	 * @return void
	 */
	public function quote ($s) {
		$_this = $this->buf;
		$_this->b = ($_this->b??'null') . (\mb_chr(34)??'null');
		$i = 0;
		while (true) {
			$c = \StringTools::fastCodeAt($s, $i++);
			if ($c === 0) {
				break;
			}
			if ($c === 8) {
				$this->buf->add("\\b");
			} else if ($c === 9) {
				$this->buf->add("\\t");
			} else if ($c === 10) {
				$this->buf->add("\\n");
			} else if ($c === 12) {
				$this->buf->add("\\f");
			} else if ($c === 13) {
				$this->buf->add("\\r");
			} else if ($c === 34) {
				$this->buf->add("\\\"");
			} else if ($c === 92) {
				$this->buf->add("\\\\");
			} else {
				$_this = $this->buf;
				$_this->b = ($_this->b??'null') . (\mb_chr($c)??'null');
			}
		}
		$_this = $this->buf;
		$_this->b = ($_this->b??'null') . (\mb_chr(34)??'null');
	}

	/**
	 * @param mixed $k
	 * @param mixed $v
	 * 
	 * @return void
	 */
	public function write ($k, $v) {
		if ($this->replacer !== null) {
			$v = ($this->replacer)($k, $v);
		}
		$_g = \Type::typeof($v);
		$__hx__switch = ($_g->index);
		if ($__hx__switch === 0) {
			$this->buf->add("null");
		} else if ($__hx__switch === 1) {
			$this->buf->add($v);
		} else if ($__hx__switch === 2) {
			$v1 = (\is_finite($v) ? \Std::string($v) : "null");
			$this->buf->add($v1);
		} else if ($__hx__switch === 3) {
			$this->buf->add(($v ? "true" : "false"));
		} else if ($__hx__switch === 4) {
			$this->fieldsString($v, \Reflect::fields($v));
		} else if ($__hx__switch === 5) {
			$this->buf->add("\"<fun>\"");
		} else if ($__hx__switch === 6) {
			$_g1 = $_g->params[0];
			if ($_g1 === Boot::getClass('String')) {
				$this->quote($v);
			} else if ($_g1 === Boot::getClass(\Array_hx::class)) {
				$v1 = $v;
				$_this = $this->buf;
				$_this->b = ($_this->b??'null') . (\mb_chr(91)??'null');
				$len = $v1->length;
				$last = $len - 1;
				$_g = 0;
				while ($_g < $len) {
					$i = $_g++;
					if ($i > 0) {
						$_this = $this->buf;
						$_this->b = ($_this->b??'null') . (\mb_chr(44)??'null');
					} else {
						$this->nind++;
					}
					if ($this->pretty) {
						$_this1 = $this->buf;
						$_this1->b = ($_this1->b??'null') . (\mb_chr(10)??'null');
					}
					if ($this->pretty) {
						$v2 = \StringTools::lpad("", $this->indent, $this->nind * mb_strlen($this->indent));
						$this->buf->add($v2);
					}
					$this->write($i, ($v1->arr[$i] ?? null));
					if ($i === $last) {
						$this->nind--;
						if ($this->pretty) {
							$_this2 = $this->buf;
							$_this2->b = ($_this2->b??'null') . (\mb_chr(10)??'null');
						}
						if ($this->pretty) {
							$v3 = \StringTools::lpad("", $this->indent, $this->nind * mb_strlen($this->indent));
							$this->buf->add($v3);
						}
					}
				}
				$_this = $this->buf;
				$_this->b = ($_this->b??'null') . (\mb_chr(93)??'null');
			} else if ($_g1 === Boot::getClass(StringMap::class)) {
				$v1 = $v;
				$o = new HxAnon();
				$data = \array_values(\array_map("strval", \array_keys($v1->data)));
				$_g_current = 0;
				$_g_length = \count($data);
				while ($_g_current < $_g_length) {
					$k = $data[$_g_current++];
					\Reflect::setField($o, $k, ($v1->data[$k] ?? null));
				}
				$v1 = $o;
				$this->fieldsString($v1, \Reflect::fields($v1));
			} else if ($_g1 === Boot::getClass(\Date::class)) {
				$this->quote($v->toString());
			} else {
				$this->classString($v);
			}
		} else if ($__hx__switch === 7) {
			$this->buf->add($v->index);
		} else if ($__hx__switch === 8) {
			$this->buf->add("\"???\"");
		}
	}
}

Boot::registerClass(JsonPrinter::class, 'haxe.format.JsonPrinter');
