<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace haxe\xml;

use \php\Boot;
use \haxe\Exception;
use \_Xml\XmlType_Impl_;
use \haxe\ds\StringMap;

class Parser {
	/**
	 * @var StringMap
	 */
	static public $escapes;

	/**
	 * @param mixed $buf
	 * @param mixed $s
	 * @param int $pos
	 * @param int $length
	 * 
	 * @return mixed
	 */
	public static function addSub ($buf, $s, $pos, $length) {
		return ($buf . \substr($s, $pos, $length));
	}

	/**
	 * @param mixed $str
	 * @param bool $strict
	 * @param int $p
	 * @param \Xml $parent
	 * 
	 * @return int
	 */
	public static function doParse ($str, $strict, $p = 0, $parent = null) {
		if ($p === null) {
			$p = 0;
		}
		$xml = null;
		$state = 1;
		$next = 1;
		$aname = null;
		$start = 0;
		$nsubs = 0;
		$nbrackets = 0;
		$c = ($p >= \strlen($str) ? 0 : \ord($str[$p]));
		$buf = "";
		$escapeNext = 1;
		$attrValQuote = -1;
		while ($c !== 0) {
			$__hx__switch = ($state);
			if ($__hx__switch === 0) {
				if ($c === 9 || $c === 10 || $c === 13 || $c === 32) {
				} else {
					$state = $next;
					continue;
				}
			} else if ($__hx__switch === 1) {
				if ($c === 60) {
					$state = 0;
					$next = 2;
				} else {
					$start = $p;
					$state = 13;
					continue;
				}
			} else if ($__hx__switch === 2) {
				if ($c === 33) {
					$pos = $p + 1;
					if ((($pos >= \strlen($str) ? 0 : \ord($str[$pos]))) === 91) {
						$p += 2;
						if (\strtoupper(\substr($str, $p, 6)) !== "CDATA[") {
							throw Exception::thrown(new XmlParserException("Expected <![CDATA[", $str, $p));
						}
						$p += 5;
						$state = 17;
						$start = $p + 1;
					} else {
						$tmp = null;
						$pos1 = $p + 1;
						if ((($pos1 >= \strlen($str) ? 0 : \ord($str[$pos1]))) !== 68) {
							$pos2 = $p + 1;
							$tmp = (($pos2 >= \strlen($str) ? 0 : \ord($str[$pos2]))) === 100;
						} else {
							$tmp = true;
						}
						if ($tmp) {
							if (\strtoupper(\substr($str, $p + 2, 6)) !== "OCTYPE") {
								throw Exception::thrown(new XmlParserException("Expected <!DOCTYPE", $str, $p));
							}
							$p += 8;
							$state = 16;
							$start = $p + 1;
						} else {
							$tmp1 = null;
							$pos3 = $p + 1;
							if ((($pos3 >= \strlen($str) ? 0 : \ord($str[$pos3]))) === 45) {
								$pos4 = $p + 2;
								$tmp1 = (($pos4 >= \strlen($str) ? 0 : \ord($str[$pos4]))) !== 45;
							} else {
								$tmp1 = true;
							}
							if ($tmp1) {
								throw Exception::thrown(new XmlParserException("Expected <!--", $str, $p));
							} else {
								$p += 2;
								$state = 15;
								$start = $p + 1;
							}
						}
					}
				} else if ($c === 47) {
					if ($parent === null) {
						throw Exception::thrown(new XmlParserException("Expected node name", $str, $p));
					}
					$start = $p + 1;
					$state = 0;
					$next = 10;
				} else if ($c === 63) {
					$state = 14;
					$start = $p;
				} else {
					$state = 3;
					$start = $p;
					continue;
				}
			} else if ($__hx__switch === 3) {
				if (!((($c >= 97) && ($c <= 122)) || (($c >= 65) && ($c <= 90)) || (($c >= 48) && ($c <= 57)) || ($c === 58) || ($c === 46) || ($c === 95) || ($c === 45))) {
					if ($p === $start) {
						throw Exception::thrown(new XmlParserException("Expected node name", $str, $p));
					}
					$xml = \Xml::createElement(\substr($str, $start, $p - $start));
					$parent->addChild($xml);
					++$nsubs;
					$state = 0;
					$next = 4;
					continue;
				}
			} else if ($__hx__switch === 4) {
				if ($c === 47) {
					$state = 11;
				} else if ($c === 62) {
					$state = 9;
				} else {
					$state = 5;
					$start = $p;
					continue;
				}
			} else if ($__hx__switch === 5) {
				if (!((($c >= 97) && ($c <= 122)) || (($c >= 65) && ($c <= 90)) || (($c >= 48) && ($c <= 57)) || ($c === 58) || ($c === 46) || ($c === 95) || ($c === 45))) {
					if ($start === $p) {
						throw Exception::thrown(new XmlParserException("Expected attribute name", $str, $p));
					}
					$tmp2 = \substr($str, $start, $p - $start);
					$aname = $tmp2;
					if ($xml->exists($tmp2)) {
						throw Exception::thrown(new XmlParserException("Duplicate attribute [" . ($tmp2??'null') . "]", $str, $p));
					}
					$state = 0;
					$next = 6;
					continue;
				}
			} else if ($__hx__switch === 6) {
				if ($c === 61) {
					$state = 0;
					$next = 7;
				} else {
					throw Exception::thrown(new XmlParserException("Expected =", $str, $p));
				}
			} else if ($__hx__switch === 7) {
				if ($c === 34 || $c === 39) {
					$buf = "";
					$state = 8;
					$start = $p + 1;
					$attrValQuote = $c;
				} else {
					throw Exception::thrown(new XmlParserException("Expected \"", $str, $p));
				}
			} else if ($__hx__switch === 8) {
				if ($c === 38) {
					$buf = ($buf . \substr($str, $start, $p - $start));
					$state = 18;
					$escapeNext = 8;
					$start = $p + 1;
				} else if ($c === 60 || $c === 62) {
					if ($strict) {
						throw Exception::thrown(new XmlParserException("Invalid unescaped " . (\mb_chr($c)??'null') . " in attribute value", $str, $p));
					} else if ($c === $attrValQuote) {
						$buf = ($buf . \substr($str, $start, $p - $start));
						$val = $buf;
						$buf = "";
						$xml->set($aname, $val);
						$state = 0;
						$next = 4;
					}
				} else {
					if ($c === $attrValQuote) {
						$buf = ($buf . \substr($str, $start, $p - $start));
						$val1 = $buf;
						$buf = "";
						$xml->set($aname, $val1);
						$state = 0;
						$next = 4;
					}
				}
			} else if ($__hx__switch === 9) {
				$p = Parser::doParse($str, $strict, $p, $xml);
				$start = $p;
				$state = 1;
			} else if ($__hx__switch === 10) {
				if (!((($c >= 97) && ($c <= 122)) || (($c >= 65) && ($c <= 90)) || (($c >= 48) && ($c <= 57)) || ($c === 58) || ($c === 46) || ($c === 95) || ($c === 45))) {
					if ($start === $p) {
						throw Exception::thrown(new XmlParserException("Expected node name", $str, $p));
					}
					$v = \substr($str, $start, $p - $start);
					if (($parent === null) || ($parent->nodeType !== 0)) {
						throw Exception::thrown(new XmlParserException("Unexpected </" . ($v??'null') . ">, tag is not open", $str, $p));
					}
					if ($parent->nodeType !== \Xml::$Element) {
						throw Exception::thrown("Bad node type, expected Element but found " . ((($parent->nodeType === null ? "null" : XmlType_Impl_::toString($parent->nodeType)))??'null'));
					}
					if ($v !== $parent->nodeName) {
						if ($parent->nodeType !== \Xml::$Element) {
							throw Exception::thrown("Bad node type, expected Element but found " . ((($parent->nodeType === null ? "null" : XmlType_Impl_::toString($parent->nodeType)))??'null'));
						}
						throw Exception::thrown(new XmlParserException("Expected </" . ($parent->nodeName??'null') . ">", $str, $p));
					}
					$state = 0;
					$next = 12;
					continue;
				}
			} else if ($__hx__switch === 11) {
				if ($c === 62) {
					$state = 1;
				} else {
					throw Exception::thrown(new XmlParserException("Expected >", $str, $p));
				}
			} else if ($__hx__switch === 12) {
				if ($c === 62) {
					if ($nsubs === 0) {
						$parent->addChild(\Xml::createPCData(""));
					}
					return $p;
				} else {
					throw Exception::thrown(new XmlParserException("Expected >", $str, $p));
				}
			} else if ($__hx__switch === 13) {
				if ($c === 60) {
					$buf = ($buf . \substr($str, $start, $p - $start));
					$child = \Xml::createPCData($buf);
					$buf = "";
					$parent->addChild($child);
					++$nsubs;
					$state = 0;
					$next = 2;
				} else if ($c === 38) {
					$buf = ($buf . \substr($str, $start, $p - $start));
					$state = 18;
					$escapeNext = 13;
					$start = $p + 1;
				}
			} else if ($__hx__switch === 14) {
				$tmp3 = null;
				if ($c === 63) {
					$pos5 = $p + 1;
					$tmp3 = (($pos5 >= \strlen($str) ? 0 : \ord($str[$pos5]))) === 62;
				} else {
					$tmp3 = false;
				}
				if ($tmp3) {
					++$p;
					$parent->addChild(\Xml::createProcessingInstruction(\substr($str, $start + 1, $p - $start - 2)));
					++$nsubs;
					$state = 1;
				}
			} else if ($__hx__switch === 15) {
				$tmp4 = null;
				$tmp5 = null;
				if ($c === 45) {
					$pos6 = $p + 1;
					$tmp5 = (($pos6 >= \strlen($str) ? 0 : \ord($str[$pos6]))) === 45;
				} else {
					$tmp5 = false;
				}
				if ($tmp5) {
					$pos7 = $p + 2;
					$tmp4 = (($pos7 >= \strlen($str) ? 0 : \ord($str[$pos7]))) === 62;
				} else {
					$tmp4 = false;
				}
				if ($tmp4) {
					$parent->addChild(\Xml::createComment(\substr($str, $start, $p - $start)));
					++$nsubs;
					$p += 2;
					$state = 1;
				}
			} else if ($__hx__switch === 16) {
				if ($c === 91) {
					++$nbrackets;
				} else if ($c === 93) {
					--$nbrackets;
				} else if (($c === 62) && ($nbrackets === 0)) {
					$parent->addChild(\Xml::createDocType(\substr($str, $start, $p - $start)));
					++$nsubs;
					$state = 1;
				}
			} else if ($__hx__switch === 17) {
				$tmp6 = null;
				$tmp7 = null;
				if ($c === 93) {
					$pos8 = $p + 1;
					$tmp7 = (($pos8 >= \strlen($str) ? 0 : \ord($str[$pos8]))) === 93;
				} else {
					$tmp7 = false;
				}
				if ($tmp7) {
					$pos9 = $p + 2;
					$tmp6 = (($pos9 >= \strlen($str) ? 0 : \ord($str[$pos9]))) === 62;
				} else {
					$tmp6 = false;
				}
				if ($tmp6) {
					$parent->addChild(\Xml::createCData(\substr($str, $start, $p - $start)));
					++$nsubs;
					$p += 2;
					$state = 1;
				}
			} else if ($__hx__switch === 18) {
				if ($c === 59) {
					$s = \substr($str, $start, $p - $start);
					if (((0 >= \strlen($s) ? 0 : \ord($s[0]))) === 35) {
						$buf = ($buf . \mb_chr((((1 >= \strlen($s) ? 0 : \ord($s[1]))) === 120 ? \Std::parseInt("0" . (\substr($s, 1, \strlen($s) - 1)??'null')) : \Std::parseInt(\substr($s, 1, \strlen($s) - 1)))));
					} else if (!\array_key_exists($s, Parser::$escapes->data)) {
						if ($strict) {
							throw Exception::thrown(new XmlParserException("Undefined entity: " . ($s??'null'), $str, $p));
						}
						$buf = ($buf . ("&" . ($s??'null') . ";"));
					} else {
						$buf = ($buf . (Parser::$escapes->data[$s] ?? null));
					}
					$start = $p + 1;
					$state = $escapeNext;
				} else if (!((($c >= 97) && ($c <= 122)) || (($c >= 65) && ($c <= 90)) || (($c >= 48) && ($c <= 57)) || ($c === 58) || ($c === 46) || ($c === 95) || ($c === 45)) && ($c !== 35)) {
					if ($strict) {
						throw Exception::thrown(new XmlParserException("Invalid character in entity: " . (\mb_chr($c)??'null'), $str, $p));
					}
					$buf = ($buf . "&");
					$buf = ($buf . \substr($str, $start, $p - $start));
					--$p;
					$start = $p + 1;
					$state = $escapeNext;
				}
			}
			$pos10 = ++$p;
			$c = ($pos10 >= \strlen($str) ? 0 : \ord($str[$pos10]));
		}
		if ($state === 1) {
			$start = $p;
			$state = 13;
		}
		if ($state === 13) {
			if ($parent->nodeType === 0) {
				if ($parent->nodeType !== \Xml::$Element) {
					throw Exception::thrown("Bad node type, expected Element but found " . ((($parent->nodeType === null ? "null" : XmlType_Impl_::toString($parent->nodeType)))??'null'));
				}
				throw Exception::thrown(new XmlParserException("Unclosed node <" . ($parent->nodeName??'null') . ">", $str, $p));
			}
			if (($p !== $start) || ($nsubs === 0)) {
				$buf = ($buf . \substr($str, $start, $p - $start));
				$parent->addChild(\Xml::createPCData($buf));
			}
			return $p;
		}
		if (!$strict && ($state === 18) && ($escapeNext === 13)) {
			$buf = ($buf . "&");
			$buf = ($buf . \substr($str, $start, $p - $start));
			$parent->addChild(\Xml::createPCData($buf));
			return $p;
		}
		throw Exception::thrown(new XmlParserException("Unexpected end", $str, $p));
	}

	/**
	 * @param mixed $s
	 * @param int $pos
	 * 
	 * @return int
	 */
	public static function fastCodeAt ($s, $pos) {
		if ($pos >= \strlen($s)) {
			return 0;
		} else {
			return \ord($s[$pos]);
		}
	}

	/**
	 * @param int $c
	 * 
	 * @return bool
	 */
	public static function isValidChar ($c) {
		if (!((($c >= 97) && ($c <= 122)) || (($c >= 65) && ($c <= 90)) || (($c >= 48) && ($c <= 57)) || ($c === 58) || ($c === 46) || ($c === 95))) {
			return $c === 45;
		} else {
			return true;
		}
	}

	/**
	 * @param string $str
	 * @param bool $strict
	 * 
	 * @return \Xml
	 */
	public static function parse ($str, $strict = false) {
		if ($strict === null) {
			$strict = false;
		}
		$doc = \Xml::createDocument();
		Parser::doParse($str, $strict, 0, $doc);
		return $doc;
	}

	/**
	 * @param mixed $s
	 * @param int $pos
	 * @param int $length
	 * 
	 * @return mixed
	 */
	public static function substr ($s, $pos, $length = null) {
		return \substr($s, $pos, $length);
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


		$h = new StringMap();
		$h->data["lt"] = "<";
		$h->data["gt"] = ">";
		$h->data["amp"] = "&";
		$h->data["quot"] = "\"";
		$h->data["apos"] = "'";
		self::$escapes = $h;
	}
}

Boot::registerClass(Parser::class, 'haxe.xml.Parser');
Parser::__hx__init();
