<?php
/**
 * Generated by Haxe 4.1.3
 */

namespace tink\cli;

use \php\_Boot\HxAnon;
use \tink\core\_Future\SyncFuture;
use \php\Boot;
use \haxe\Exception;
use \tink\core\Noise;
use \tink\core\TypedError;
use \tink\core\Outcome;
use \tink\core\_Lazy\LazyConst;
use \php\_Boot\HxString;
use \tink\core\FutureObject;

class Router {
	/**
	 * @var mixed
	 */
	public $command;
	/**
	 * @var bool
	 */
	public $hasFlags;
	/**
	 * @var Prompt
	 */
	public $prompt;

	/**
	 * @param \Array_hx $args
	 * 
	 * @return \Array_hx
	 */
	public static function expandAssignments ($args) {
		$ret = new \Array_hx();
		$flags = true;
		$_g = 0;
		while ($_g < $args->length) {
			$arg = ($args->arr[$_g] ?? null);
			++$_g;
			if ($arg === "--") {
				$flags = false;
			}
			if (!$flags) {
				$ret->arr[$ret->length++] = $arg;
			} else {
				$_g1 = HxString::indexOf($arg, "=");
				$_g2 = HxString::charCodeAt($arg, 1);
				$_g3 = HxString::charCodeAt($arg, 0);
				if ($_g3 === null) {
					$ret->arr[$ret->length++] = $arg;
				} else if ($_g3 === 45) {
					if ($_g2 === null) {
						$ret->arr[$ret->length++] = $arg;
					} else if ($_g2 === 45) {
						if ($_g1 !== -1) {
							$x = \mb_substr($arg, 0, $_g1);
							$ret->arr[$ret->length++] = $x;
							$x1 = \mb_substr($arg, $_g1 + 1, null);
							$ret->arr[$ret->length++] = $x1;
						} else {
							$ret->arr[$ret->length++] = $arg;
						}
					} else {
						$ret->arr[$ret->length++] = $arg;
					}
				} else {
					$ret->arr[$ret->length++] = $arg;
				}
			}
		}
		return $ret;
	}

	/**
	 * @param mixed $command
	 * @param Prompt $prompt
	 * @param bool $hasFlags
	 * 
	 * @return void
	 */
	public function __construct ($command, $prompt, $hasFlags) {
		$this->command = $command;
		$this->prompt = $prompt;
		$this->hasFlags = $hasFlags;
	}

	/**
	 * @param \Array_hx $args
	 * 
	 * @return FutureObject
	 */
	public function process ($args) {
		return new SyncFuture(new LazyConst(Outcome::Success(Noise::Noise())));
	}

	/**
	 * @param \Array_hx $args
	 * @param int $index
	 * 
	 * @return int
	 */
	public function processAlias ($args, $index) {
		return -1;
	}

	/**
	 * @param \Array_hx $args
	 * 
	 * @return Outcome
	 */
	public function processArgs ($args) {
		$_gthis = $this;
		if (!$this->hasFlags) {
			return Outcome::Success($args);
		} else {
			return TypedError::catchExceptions(function () use (&$args, &$_gthis) {
				$args1 = Router::expandAssignments($args);
				$rest = new \Array_hx();
				$i = 0;
				$flagsEnded = false;
				while ($i < $args1->length) {
					$arg = ($args1->arr[$i] ?? null);
					if ($arg === "--") {
						$flagsEnded = true;
						++$i;
					} else if (!$flagsEnded && (HxString::charCodeAt($arg, 0) === 45)) {
						$_g = $_gthis->processFlag($args1, $i);
						if ($_g === -1) {
							if (HxString::charCodeAt($arg, 1) !== 45) {
								$_g1 = $_gthis->processAlias($args1, $i);
								if ($_g1 === -1) {
									throw Exception::thrown("Unrecognized alias \"" . ($arg??'null') . "\"");
								} else {
									$i += $_g1 + 1;
								}
							} else {
								throw Exception::thrown("Unrecognized flag \"" . ($arg??'null') . "\"");
							}
						} else {
							$i += $_g + 1;
						}
					} else {
						$rest->arr[$rest->length++] = $arg;
						++$i;
					}
				}
				return $rest;
			}, null, new HxAnon([
				"fileName" => "tink/cli/Router.hx",
				"lineNumber" => 25,
				"className" => "tink.cli.Router",
				"methodName" => "processArgs",
			]));
		}
	}

	/**
	 * @param \Array_hx $args
	 * @param int $index
	 * 
	 * @return int
	 */
	public function processFlag ($args, $index) {
		return -1;
	}

	/**
	 * @return FutureObject
	 */
	public function promptRequired () {
		return new SyncFuture(new LazyConst(Outcome::Success(Noise::Noise())));
	}
}

Boot::registerClass(Router::class, 'tink.cli.Router');
