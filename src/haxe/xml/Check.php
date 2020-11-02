<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace haxe\xml;

use \php\Boot;
use \haxe\Exception;
use \haxe\xml\_Check\CheckResult;
use \php\_Boot\HxString;
use \_Xml\XmlType_Impl_;
use \haxe\iterators\ArrayIterator;

class Check {
	/**
	 * @var \EReg
	 */
	static public $blanks;

	/**
	 * @param \Xml $x
	 * @param Rule $r
	 * 
	 * @return CheckResult
	 */
	public static function check ($x, $r) {
		while (true) {
			$__hx__switch = ($r->index);
			if ($__hx__switch === 0) {
				$_g = $r->params[2];
				$_g1 = $r->params[1];
				$_g2 = $r->params[0];
				$childs = $_g;
				$tmp = null;
				if ($x->nodeType === \Xml::$Element) {
					if ($x->nodeType !== \Xml::$Element) {
						throw Exception::thrown("Bad node type, expected Element but found " . ((($x->nodeType === null ? "null" : XmlType_Impl_::toString($x->nodeType)))??'null'));
					}
					$tmp = $x->nodeName !== $_g2;
				} else {
					$tmp = true;
				}
				if ($tmp) {
					return CheckResult::CElementExpected($_g2, $x);
				}
				$attribs = ($_g1 === null ? new \Array_hx() : (clone $_g1));
				$xatt = $x->attributes();
				while ($xatt->hasNext()) {
					$xatt1 = $xatt->next();
					$found = false;
					$_g3 = 0;
					while ($_g3 < $attribs->length) {
						$att = ($attribs->arr[$_g3] ?? null);
						++$_g3;
						$_g4 = $att->params[1];
						$_g5 = $att->params[0];
						if ($xatt1 !== $_g5) {
							continue;
						}
						if (($_g4 !== null) && !Check::filterMatch($x->get($xatt1), $_g4)) {
							return CheckResult::CInvalidAttrib($_g5, $x, $_g4);
						}
						$attribs->remove($att);
						$found = true;
					}
					if (!$found) {
						return CheckResult::CExtraAttrib($xatt1, $x);
					}
				}
				$_g6 = 0;
				while ($_g6 < $attribs->length) {
					$att1 = ($attribs->arr[$_g6] ?? null);
					++$_g6;
					if ($att1->params[2] === null) {
						return CheckResult::CMissingAttrib($att1->params[0], $x);
					}
				}
				if ($_g === null) {
					$childs = Rule::RList(new \Array_hx());
				}
				if (($x->nodeType !== \Xml::$Document) && ($x->nodeType !== \Xml::$Element)) {
					throw Exception::thrown("Bad node type, expected Element or Document but found " . ((($x->nodeType === null ? "null" : XmlType_Impl_::toString($x->nodeType)))??'null'));
				}
				$m = Check::checkList(new ArrayIterator($x->children), $childs);
				if ($m !== CheckResult::CMatch()) {
					return CheckResult::CInElement($x, $m);
				}
				$_g7 = 0;
				while ($_g7 < $attribs->length) {
					$att2 = ($attribs->arr[$_g7] ?? null);
					++$_g7;
					$x->set($att2->params[0], $att2->params[2]);
				}
				return CheckResult::CMatch();
			} else if ($__hx__switch === 1) {
				$_g8 = $r->params[0];
				if (($x->nodeType !== \Xml::$PCData) && ($x->nodeType !== \Xml::$CData)) {
					return CheckResult::CDataExpected($x);
				}
				$tmp1 = null;
				if ($_g8 !== null) {
					if (($x->nodeType === \Xml::$Document) || ($x->nodeType === \Xml::$Element)) {
						throw Exception::thrown("Bad node type, unexpected " . ((($x->nodeType === null ? "null" : XmlType_Impl_::toString($x->nodeType)))??'null'));
					}
					$tmp1 = !Check::filterMatch($x->nodeValue, $_g8);
				} else {
					$tmp1 = false;
				}
				if ($tmp1) {
					return CheckResult::CInvalidData($x, $_g8);
				}
				return CheckResult::CMatch();
			} else if ($__hx__switch === 4) {
				$_g9 = $r->params[0];
				if ($_g9->length === 0) {
					throw Exception::thrown("No choice possible");
				}
				$_g10 = 0;
				while ($_g10 < $_g9->length) {
					if (Check::check($x, ($_g9->arr[$_g10++] ?? null)) === CheckResult::CMatch()) {
						return CheckResult::CMatch();
					}
				}
				$r = ($_g9->arr[0] ?? null);
				continue;
			} else if ($__hx__switch === 5) {
				$r = $r->params[0];
				continue;
			} else {
				throw Exception::thrown("Unexpected " . (\Std::string($r)??'null'));
			}
		}
	}

	/**
	 * @param \Xml $x
	 * @param Rule $r
	 * 
	 * @return void
	 */
	public static function checkDocument ($x, $r) {
		if ($x->nodeType !== \Xml::$Document) {
			throw Exception::thrown("Document expected");
		}
		if (($x->nodeType !== \Xml::$Document) && ($x->nodeType !== \Xml::$Element)) {
			throw Exception::thrown("Bad node type, expected Element or Document but found " . ((($x->nodeType === null ? "null" : XmlType_Impl_::toString($x->nodeType)))??'null'));
		}
		$m = Check::checkList(new ArrayIterator($x->children), $r);
		if ($m === CheckResult::CMatch()) {
			return;
		}
		throw Exception::thrown(Check::makeError($m));
	}

	/**
	 * @param object $it
	 * @param Rule $r
	 * 
	 * @return CheckResult
	 */
	public static function checkList ($it, $r) {
		$__hx__switch = ($r->index);
		if ($__hx__switch === 2) {
			$_g = $r->params[1];
			$_g1 = $r->params[0];
			$found = false;
			while ($it->hasNext()) {
				$x = $it->next();
				if (Check::isBlank($x)) {
					continue;
				}
				$m = Check::checkList(new ArrayIterator(\Array_hx::wrap([$x])), $_g1);
				if ($m !== CheckResult::CMatch()) {
					return $m;
				}
				$found = true;
			}
			if ($_g && !$found) {
				return CheckResult::CMissing($_g1);
			}
			return CheckResult::CMatch();
		} else if ($__hx__switch === 3) {
			$_g = $r->params[1];
			$rules = (clone $r->params[0]);
			while ($it->hasNext()) {
				$x = $it->next();
				if (Check::isBlank($x)) {
					continue;
				}
				$found = false;
				$_g1 = 0;
				while ($_g1 < $rules->length) {
					$r1 = ($rules->arr[$_g1] ?? null);
					++$_g1;
					$m = Check::checkList(new ArrayIterator(\Array_hx::wrap([$x])), $r1);
					if ($m === CheckResult::CMatch()) {
						$found = true;
						if ($r1->index === 2) {
							$_g2 = $r1->params[0];
							if ($r1->params[1]) {
								$_g3 = 0;
								$_g4 = $rules->length;
								while ($_g3 < $_g4) {
									$i = $_g3++;
									if (($rules->arr[$i] ?? null) === $r1) {
										$rules->offsetSet($i, Rule::RMulti($_g2));
									}
								}
							}
						} else {
							$rules->remove($r1);
						}
						break;
					} else if ($_g && !Check::isNullable($r1)) {
						return $m;
					}
				}
				if (!$found) {
					return CheckResult::CExtra($x);
				}
			}
			$_g = 0;
			while ($_g < $rules->length) {
				$r1 = ($rules->arr[$_g] ?? null);
				++$_g;
				if (!Check::isNullable($r1)) {
					return CheckResult::CMissing($r1);
				}
			}
			return CheckResult::CMatch();
		} else {
			$found = false;
			while ($it->hasNext()) {
				$x = $it->next();
				if (Check::isBlank($x)) {
					continue;
				}
				$m = Check::check($x, $r);
				if ($m !== CheckResult::CMatch()) {
					return $m;
				}
				$found = true;
				break;
			}
			if (!$found) {
				if ($r->index !== 5) {
					return CheckResult::CMissing($r);
				}
			}
			while ($it->hasNext()) {
				$x = $it->next();
				if (Check::isBlank($x)) {
					continue;
				}
				return CheckResult::CExtra($x);
			}
			return CheckResult::CMatch();
		}
	}

	/**
	 * @param \Xml $x
	 * @param Rule $r
	 * 
	 * @return void
	 */
	public static function checkNode ($x, $r) {
		$m = Check::checkList(new ArrayIterator(\Array_hx::wrap([$x])), $r);
		if ($m === CheckResult::CMatch()) {
			return;
		}
		throw Exception::thrown(Check::makeError($m));
	}

	/**
	 * @param string $s
	 * @param Filter $f
	 * 
	 * @return bool
	 */
	public static function filterMatch ($s, $f) {
		while (true) {
			$__hx__switch = ($f->index);
			if ($__hx__switch === 0) {
				$f = Filter::FReg(new \EReg("[0-9]+", ""));
				continue;
			} else if ($__hx__switch === 1) {
				$f = Filter::FEnum(\Array_hx::wrap([
					"true",
					"false",
					"0",
					"1",
				]));
				continue;
			} else if ($__hx__switch === 2) {
				$_g = $f->params[0];
				$_g1 = 0;
				while ($_g1 < $_g->length) {
					if ($s === ($_g->arr[$_g1++] ?? null)) {
						return true;
					}
				}
				return false;
			} else if ($__hx__switch === 3) {
				return $f->params[0]->match($s);
			}
		}
	}

	/**
	 * @param \Xml $x
	 * 
	 * @return bool
	 */
	public static function isBlank ($x) {
		$tmp = null;
		if ($x->nodeType === \Xml::$PCData) {
			$tmp1 = Check::$blanks;
			if (($x->nodeType === \Xml::$Document) || ($x->nodeType === \Xml::$Element)) {
				throw Exception::thrown("Bad node type, unexpected " . ((($x->nodeType === null ? "null" : XmlType_Impl_::toString($x->nodeType)))??'null'));
			}
			$tmp = $tmp1->match($x->nodeValue);
		} else {
			$tmp = false;
		}
		if (!$tmp) {
			return $x->nodeType === \Xml::$Comment;
		} else {
			return true;
		}
	}

	/**
	 * @param Rule $r
	 * 
	 * @return bool
	 */
	public static function isNullable ($r) {
		$__hx__switch = ($r->index);
		if ($__hx__switch === 0) {
			return false;
		} else if ($__hx__switch === 1) {
			return false;
		} else if ($__hx__switch === 2) {
			if ($r->params[1] === true) {
				return Check::isNullable($r->params[0]);
			} else {
				return true;
			}
		} else if ($__hx__switch === 3) {
			$_g = $r->params[0];
			$_g1 = 0;
			while ($_g1 < $_g->length) {
				if (!Check::isNullable(($_g->arr[$_g1++] ?? null))) {
					return false;
				}
			}
			return true;
		} else if ($__hx__switch === 4) {
			$_g = $r->params[0];
			$_g1 = 0;
			while ($_g1 < $_g->length) {
				if (Check::isNullable(($_g->arr[$_g1++] ?? null))) {
					return true;
				}
			}
			return false;
		} else if ($__hx__switch === 5) {
			return true;
		}
	}

	/**
	 * @param CheckResult $m
	 * @param \Array_hx $path
	 * 
	 * @return string
	 */
	public static function makeError ($m, $path = null) {
		while (true) {
			if ($path === null) {
				$path = new \Array_hx();
			}
			$__hx__switch = ($m->index);
			if ($__hx__switch === 0) {
				throw Exception::thrown("assert");
			} else if ($__hx__switch === 1) {
				return (Check::makeWhere($path)??'null') . "Missing " . (Check::makeRule($m->params[0])??'null');
			} else if ($__hx__switch === 2) {
				return (Check::makeWhere($path)??'null') . "Unexpected " . (Check::makeString($m->params[0])??'null');
			} else if ($__hx__switch === 3) {
				return (Check::makeWhere($path)??'null') . (Check::makeString($m->params[1])??'null') . " while expected element " . ($m->params[0]??'null');
			} else if ($__hx__switch === 4) {
				return (Check::makeWhere($path)??'null') . (Check::makeString($m->params[0])??'null') . " while data expected";
			} else if ($__hx__switch === 5) {
				$path->arr[$path->length++] = $m->params[1];
				return (Check::makeWhere($path)??'null') . "unexpected attribute " . ($m->params[0]??'null');
			} else if ($__hx__switch === 6) {
				$path->arr[$path->length++] = $m->params[1];
				return (Check::makeWhere($path)??'null') . "missing required attribute " . ($m->params[0]??'null');
			} else if ($__hx__switch === 7) {
				$path->arr[$path->length++] = $m->params[1];
				return (Check::makeWhere($path)??'null') . "invalid attribute value for " . ($m->params[0]??'null');
			} else if ($__hx__switch === 8) {
				return (Check::makeWhere($path)??'null') . "invalid data format for " . (Check::makeString($m->params[0])??'null');
			} else if ($__hx__switch === 9) {
				$path->arr[$path->length++] = $m->params[0];
				$m = $m->params[1];
				continue;
			}
		}
	}

	/**
	 * @param Rule $r
	 * 
	 * @return string
	 */
	public static function makeRule ($r) {
		while (true) {
			$__hx__switch = ($r->index);
			if ($__hx__switch === 0) {
				return "element " . ($r->params[0]??'null');
			} else if ($__hx__switch === 1) {
				return "data";
			} else if ($__hx__switch === 2) {
				$r = $r->params[0];
				continue;
			} else if ($__hx__switch === 3) {
				$r = ($r->params[0]->arr[0] ?? null);
				continue;
			} else if ($__hx__switch === 4) {
				$r = ($r->params[0]->arr[0] ?? null);
				continue;
			} else if ($__hx__switch === 5) {
				$r = $r->params[0];
				continue;
			}
		}
	}

	/**
	 * @param \Xml $x
	 * 
	 * @return string
	 */
	public static function makeString ($x) {
		if ($x->nodeType === \Xml::$Element) {
			if ($x->nodeType !== \Xml::$Element) {
				throw Exception::thrown("Bad node type, expected Element but found " . ((($x->nodeType === null ? "null" : XmlType_Impl_::toString($x->nodeType)))??'null'));
			}
			return "element " . ($x->nodeName??'null');
		}
		if (($x->nodeType === \Xml::$Document) || ($x->nodeType === \Xml::$Element)) {
			throw Exception::thrown("Bad node type, unexpected " . ((($x->nodeType === null ? "null" : XmlType_Impl_::toString($x->nodeType)))??'null'));
		}
		$s = HxString::split(HxString::split(HxString::split($x->nodeValue, "\x0D")->join("\\r"), "\x0A")->join("\\n"), "\x09")->join("\\t");
		if (mb_strlen($s) > 20) {
			return (\mb_substr($s, 0, 17)??'null') . "...";
		}
		return $s;
	}

	/**
	 * @param \Array_hx $path
	 * 
	 * @return string
	 */
	public static function makeWhere ($path) {
		if ($path->length === 0) {
			return "";
		}
		$s = "In ";
		$first = true;
		$_g = 0;
		while ($_g < $path->length) {
			$x = ($path->arr[$_g] ?? null);
			++$_g;
			if ($first) {
				$first = false;
			} else {
				$s = ($s??'null') . ".";
			}
			if ($x->nodeType !== \Xml::$Element) {
				throw Exception::thrown("Bad node type, expected Element but found " . ((($x->nodeType === null ? "null" : XmlType_Impl_::toString($x->nodeType)))??'null'));
			}
			$s = ($s??'null') . ($x->nodeName??'null');
		}
		return ($s??'null') . ": ";
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


		self::$blanks = new \EReg("^[ \x0D\x0A\x09]*\$", "");
	}
}

Boot::registerClass(Check::class, 'haxe.xml.Check');
Check::__hx__init();