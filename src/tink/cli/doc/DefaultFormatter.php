<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace tink\cli\doc;

use \php\Boot;
use \tink\cli\DocFormatter;
use \php\_Boot\HxString;

class DefaultFormatter implements DocFormatter {
	/**
	 * @var \EReg
	 */
	public $re;
	/**
	 * @var string
	 */
	public $root;

	/**
	 * @param string $root
	 * 
	 * @return void
	 */
	public function __construct ($root = null) {
		$this->re = new \EReg("^\\s*\\*?\\s{0,2}(.*)\$", "");
		$this->root = $root;
	}

	/**
	 * @param object $spec
	 * 
	 * @return string
	 */
	public function format ($spec) {
		$_gthis = $this;
		$out = new \StringBuf();
		$out->add("\x0A");
		$_g = $this->formatDoc($spec->doc);
		if ($_g !== null) {
			$out->add("" . ($_g??'null') . "\x0A" . "\x0A");
		}
		$_this = $spec->commands;
		$result = [];
		$data = $_this->arr;
		$_g_current = 0;
		$_g_length = \count($data);
		while ($_g_current < $_g_length) {
			$item = $data[$_g_current++];
			if (!$item->isDefault) {
				$result[] = $item;
			}
		}
		$subs = \Array_hx::wrap($result);
		if ($this->root !== null) {
			$out->add("  Usage: " . ($this->root??'null') . "\x0A");
		}
		$_g = \Lambda::find($spec->commands, function ($c) {
			return $c->isDefault;
		});
		if ($_g !== null) {
			$_g1 = $this->formatDoc($_g->doc);
			if ($_g1 !== null) {
				$v = ($this->indent($_g1, 4)??'null') . "\x0A";
				$out->add(($v??'null') . "\x0A");
			}
		}
		if ($subs->length > 0) {
			$maxCommandLength = \Lambda::fold($subs, function ($command, $max) {
				$_g = 0;
				$_g1 = $command->names;
				while ($_g < $_g1->length) {
					$name = ($_g1->arr[$_g] ?? null);
					++$_g;
					if (mb_strlen($name) > $max) {
						$max = mb_strlen($name);
					}
				}
				return $max;
			}, 0);
			if ($this->root !== null) {
				$out->add("  Usage: " . ($this->root??'null') . " <subcommand>" . "\x0A");
			}
			$out->add("    Subcommands:" . "\x0A");
			$addCommand = function ($name, $doc) use (&$out, &$_gthis, &$maxCommandLength) {
				if ($doc === null) {
					$doc = "(doc missing)";
				}
				$v = $_gthis->indent((\StringTools::lpad($name, " ", $maxCommandLength)??'null') . " : " . (\trim($_gthis->indent($doc, $maxCommandLength + 3))??'null'), 6);
				$out->add(($v??'null') . "\x0A");
			};
			$_g = 0;
			while ($_g < $subs->length) {
				$command = ($subs->arr[$_g] ?? null);
				++$_g;
				$name = ($command->names->arr[0] ?? null);
				$addCommand($name, $this->formatDoc($command->doc));
				if ($command->names->length > 1) {
					$_g1 = 1;
					$_g2 = $command->names->length;
					while ($_g1 < $_g2) {
						$addCommand(($command->names->arr[$_g1++] ?? null), "Alias of " . ($name??'null'));
					}
				}
			}
		}
		if ($spec->flags->length > 0) {
			$nameOf = function ($flag) {
				$variants = $flag->names->join(", ");
				if ($flag->aliases->length > 0) {
					$_this = $flag->aliases;
					$result = [];
					$data = $_this->arr;
					$_g_current = 0;
					$_g_length = \count($data);
					while ($_g_current < $_g_length) {
						$result[] = ("-" . ($data[$_g_current++]??'null'));
					}
					$variants = ($variants??'null') . ", " . (\Array_hx::wrap($result)->join(", ")??'null');
				}
				return $variants;
			};
			$maxFlagLength = \Lambda::fold($spec->flags, function ($flag, $max) use (&$nameOf) {
				$name = $nameOf($flag);
				if (mb_strlen($name) > $max) {
					$max = mb_strlen($name);
				}
				return $max;
			}, 0);
			$addFlag = function ($name, $doc) use (&$maxFlagLength, &$out, &$_gthis) {
				if ($doc === null) {
					$doc = "";
				}
				$v = $_gthis->indent((\StringTools::lpad($name, " ", $maxFlagLength)??'null') . " : " . (\trim($_gthis->indent($doc, $maxFlagLength + 3))??'null'), 6);
				$out->add(($v??'null') . "\x0A");
			};
			$out->add("\x0A");
			$out->add("  Flags:" . "\x0A");
			$_g = 0;
			$_g1 = $spec->flags;
			while ($_g < $_g1->length) {
				$flag = ($_g1->arr[$_g] ?? null);
				++$_g;
				$addFlag($nameOf($flag), $this->formatDoc($flag->doc));
			}
		}
		return $out->b;
	}

	/**
	 * @param string $doc
	 * 
	 * @return string
	 */
	public function formatDoc ($doc) {
		$_gthis = $this;
		if ($doc === null) {
			return null;
		}
		$_this = HxString::split($doc, "\x0A");
		$f = Boot::getStaticClosure(\StringTools::class, 'trim');
		$result = [];
		$data = $_this->arr;
		$_g_current = 0;
		$_g_length = \count($data);
		while ($_g_current < $_g_length) {
			$result[] = $f($data[$_g_current++]);
		}
		$lines = \Array_hx::wrap($result);
		while (($lines->arr[0] ?? null) === "") {
			$lines = $lines->slice(1);
		}
		while (($lines->arr[$lines->length - 1] ?? null) === "") {
			if ($lines->length > 0) {
				$lines->length--;
			}
			\array_pop($lines->arr);
		}
		$result = [];
		$data = $lines->arr;
		$_g_current = 0;
		$_g_length = \count($data);
		while ($_g_current < $_g_length) {
			$item = $data[$_g_current++];
			$result[] = ($_gthis->re->match($item) ? $_gthis->re->matched(1) : $item);
		}
		return \Array_hx::wrap($result)->join("\x0A");
	}

	/**
	 * @param string $v
	 * @param int $level
	 * 
	 * @return string
	 */
	public function indent ($v, $level) {
		$_this = HxString::split($v, "\x0A");
		$result = [];
		$data = $_this->arr;
		$_g_current = 0;
		$_g_length = \count($data);
		while ($_g_current < $_g_length) {
			$item = $data[$_g_current++];
			$result[] = ((\StringTools::lpad("", " ", $level)??'null') . ($item??'null'));
		}
		return \Array_hx::wrap($result)->join("\x0A");
	}
}

Boot::registerClass(DefaultFormatter::class, 'tink.cli.doc.DefaultFormatter');
