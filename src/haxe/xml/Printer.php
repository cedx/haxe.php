<?php
/**
 * Generated by Haxe 4.1.3
 */

namespace haxe\xml;

use \php\Boot;
use \haxe\Exception;
use \_Xml\XmlType_Impl_;

/**
 * This class provides utility methods to convert Xml instances to
 * String representation.
 */
class Printer {
	/**
	 * @var \StringBuf
	 */
	public $output;
	/**
	 * @var bool
	 */
	public $pretty;

	/**
	 * Convert `Xml` to string representation.
	 * Set `pretty` to `true` to prettify the result.
	 * 
	 * @param \Xml $xml
	 * @param bool $pretty
	 * 
	 * @return string
	 */
	public static function print ($xml, $pretty = false) {
		if ($pretty === null) {
			$pretty = false;
		}
		$printer = new Printer($pretty);
		$printer->writeNode($xml, "");
		return $printer->output->b;
	}

	/**
	 * @param bool $pretty
	 * 
	 * @return void
	 */
	public function __construct ($pretty) {
		$this->output = new \StringBuf();
		$this->pretty = $pretty;
	}

	/**
	 * @param \Xml $value
	 * 
	 * @return bool
	 */
	public function hasChildren ($value) {
		if (($value->nodeType !== \Xml::$Document) && ($value->nodeType !== \Xml::$Element)) {
			throw Exception::thrown("Bad node type, expected Element or Document but found " . ((($value->nodeType === null ? "null" : XmlType_Impl_::toString($value->nodeType)))??'null'));
		}
		$_this = $value->children;
		$_g_current = 0;
		while ($_g_current < $_this->length) {
			$child = ($_this->arr[$_g_current++] ?? null);
			$__hx__switch = ($child->nodeType);
			if ($__hx__switch === 0 || $__hx__switch === 1) {
				return true;
			} else if ($__hx__switch === 2 || $__hx__switch === 3) {
				if (($child->nodeType === \Xml::$Document) || ($child->nodeType === \Xml::$Element)) {
					throw Exception::thrown("Bad node type, unexpected " . ((($child->nodeType === null ? "null" : XmlType_Impl_::toString($child->nodeType)))??'null'));
				}
				if (mb_strlen(\ltrim($child->nodeValue)) !== 0) {
					return true;
				}
			} else {
			}
		}
		return false;
	}

	/**
	 * @return void
	 */
	public function newline () {
		if ($this->pretty) {
			$this->output->add("\x0A");
		}
	}

	/**
	 * @param string $input
	 * 
	 * @return void
	 */
	public function write ($input) {
		$this->output->add($input);
	}

	/**
	 * @param \Xml $value
	 * @param string $tabs
	 * 
	 * @return void
	 */
	public function writeNode ($value, $tabs) {
		$__hx__switch = ($value->nodeType);
		if ($__hx__switch === 0) {
			$this->output->add(($tabs??'null') . "<");
			if ($value->nodeType !== \Xml::$Element) {
				throw Exception::thrown("Bad node type, expected Element but found " . ((($value->nodeType === null ? "null" : XmlType_Impl_::toString($value->nodeType)))??'null'));
			}
			$this->output->add($value->nodeName);
			$attribute = $value->attributes();
			while ($attribute->hasNext()) {
				$attribute1 = $attribute->next();
				$this->output->add(" " . ($attribute1??'null') . "=\"");
				$input = \htmlspecialchars($value->get($attribute1), \ENT_QUOTES | \ENT_HTML401);
				$this->output->add($input);
				$this->output->add("\"");
			}
			if ($this->hasChildren($value)) {
				$this->output->add(">");
				if ($this->pretty) {
					$this->output->add("\x0A");
				}
				if (($value->nodeType !== \Xml::$Document) && ($value->nodeType !== \Xml::$Element)) {
					throw Exception::thrown("Bad node type, expected Element or Document but found " . ((($value->nodeType === null ? "null" : XmlType_Impl_::toString($value->nodeType)))??'null'));
				}
				$_this = $value->children;
				$_g_current = 0;
				while ($_g_current < $_this->length) {
					$this->writeNode(($_this->arr[$_g_current++] ?? null), ($this->pretty ? ($tabs??'null') . "\x09" : $tabs));
				}
				$this->output->add(($tabs??'null') . "</");
				if ($value->nodeType !== \Xml::$Element) {
					throw Exception::thrown("Bad node type, expected Element but found " . ((($value->nodeType === null ? "null" : XmlType_Impl_::toString($value->nodeType)))??'null'));
				}
				$this->output->add($value->nodeName);
				$this->output->add(">");
				if ($this->pretty) {
					$this->output->add("\x0A");
				}
			} else {
				$this->output->add("/>");
				if ($this->pretty) {
					$this->output->add("\x0A");
				}
			}
		} else if ($__hx__switch === 1) {
			if (($value->nodeType === \Xml::$Document) || ($value->nodeType === \Xml::$Element)) {
				throw Exception::thrown("Bad node type, unexpected " . ((($value->nodeType === null ? "null" : XmlType_Impl_::toString($value->nodeType)))??'null'));
			}
			$nodeValue = $value->nodeValue;
			if (mb_strlen($nodeValue) !== 0) {
				$input = null;
				if (!null) {
					$input = \ENT_NOQUOTES;
				}
				$input1 = ($tabs??'null') . (\htmlspecialchars($nodeValue, $input)??'null');
				$this->output->add($input1);
				if ($this->pretty) {
					$this->output->add("\x0A");
				}
			}
		} else if ($__hx__switch === 2) {
			$this->output->add(($tabs??'null') . "<![CDATA[");
			if (($value->nodeType === \Xml::$Document) || ($value->nodeType === \Xml::$Element)) {
				throw Exception::thrown("Bad node type, unexpected " . ((($value->nodeType === null ? "null" : XmlType_Impl_::toString($value->nodeType)))??'null'));
			}
			$this->output->add($value->nodeValue);
			$this->output->add("]]>");
			if ($this->pretty) {
				$this->output->add("\x0A");
			}
		} else if ($__hx__switch === 3) {
			if (($value->nodeType === \Xml::$Document) || ($value->nodeType === \Xml::$Element)) {
				throw Exception::thrown("Bad node type, unexpected " . ((($value->nodeType === null ? "null" : XmlType_Impl_::toString($value->nodeType)))??'null'));
			}
			$commentContent = $value->nodeValue;
			$commentContent = (new \EReg("[\x0A\x0D\x09]+", "g"))->replace($commentContent, "");
			$commentContent = "<!--" . ($commentContent??'null') . "-->";
			$this->output->add($tabs);
			$input = \trim($commentContent);
			$this->output->add($input);
			if ($this->pretty) {
				$this->output->add("\x0A");
			}
		} else if ($__hx__switch === 4) {
			if (($value->nodeType === \Xml::$Document) || ($value->nodeType === \Xml::$Element)) {
				throw Exception::thrown("Bad node type, unexpected " . ((($value->nodeType === null ? "null" : XmlType_Impl_::toString($value->nodeType)))??'null'));
			}
			$this->output->add("<!DOCTYPE " . ($value->nodeValue??'null') . ">");
			if ($this->pretty) {
				$this->output->add("\x0A");
			}
		} else if ($__hx__switch === 5) {
			if (($value->nodeType === \Xml::$Document) || ($value->nodeType === \Xml::$Element)) {
				throw Exception::thrown("Bad node type, unexpected " . ((($value->nodeType === null ? "null" : XmlType_Impl_::toString($value->nodeType)))??'null'));
			}
			$this->output->add("<?" . ($value->nodeValue??'null') . "?>");
			if ($this->pretty) {
				$this->output->add("\x0A");
			}
		} else if ($__hx__switch === 6) {
			if (($value->nodeType !== \Xml::$Document) && ($value->nodeType !== \Xml::$Element)) {
				throw Exception::thrown("Bad node type, expected Element or Document but found " . ((($value->nodeType === null ? "null" : XmlType_Impl_::toString($value->nodeType)))??'null'));
			}
			$_this = $value->children;
			$_g_current = 0;
			while ($_g_current < $_this->length) {
				$this->writeNode(($_this->arr[$_g_current++] ?? null), $tabs);
			}
		}
	}
}

Boot::registerClass(Printer::class, 'haxe.xml.Printer');
