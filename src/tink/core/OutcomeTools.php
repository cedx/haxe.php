<?php
/**
 * Generated by Haxe 4.1.2
 */

namespace tink\core;

use \php\_Boot\HxAnon;
use \tink\core\_Lazy\LazyObject;
use \tink\core\_Future\SyncFuture;
use \php\Boot;
use \haxe\Exception;
use \haxe\ds\Option as DsOption;
use \tink\core\_Lazy\LazyConst;
use \haxe\NativeStackTrace;
use \tink\core\_Outcome\OutcomeMapper_Impl_;

class OutcomeTools {
	/**
	 *  Try to run `f` and wraps the result in `Success`,
	 *  thrown exceptions are transformed by `report` then wrapped into a `Failure`
	 * 
	 * @param \Closure $f
	 * @param \Closure $report
	 * 
	 * @return Outcome
	 */
	public static function attempt ($f, $report) {
		try {
			return Outcome::Success($f());
		} catch(\Throwable $_g) {
			NativeStackTrace::saveStack($_g);
			return Outcome::Failure($report(Exception::caught($_g)->unwrap()));
		}
	}

	/**
	 *   Returns `true` if the outcome is `Some` and the value is equal to `v`, otherwise `false`
	 * 
	 * @param Outcome $outcome
	 * @param mixed $to
	 * 
	 * @return bool
	 */
	public static function equals ($outcome, $to) {
		$__hx__switch = ($outcome->index);
		if ($__hx__switch === 0) {
			return Boot::equal($outcome->params[0], $to);
		} else if ($__hx__switch === 1) {
			return false;
		}
	}

	/**
	 *  Transforms the outcome with a transform function
	 *  Different from `map`, the transform function of `flatMap` returns an `Outcome`
	 * 
	 * @param Outcome $o
	 * @param object $mapper
	 * 
	 * @return Outcome
	 */
	public static function flatMap ($o, $mapper) {
		return OutcomeMapper_Impl_::apply($mapper, $o);
	}

	/**
	 * @param Outcome $o
	 * 
	 * @return Outcome
	 */
	public static function flatten ($o) {
		$__hx__switch = ($o->index);
		if ($__hx__switch === 0) {
			$_g = $o->params[0];
			$__hx__switch = ($_g->index);
			if ($__hx__switch === 0) {
				return Outcome::Success($_g->params[0]);
			} else if ($__hx__switch === 1) {
				return Outcome::Failure($_g->params[0]);
			}
		} else if ($__hx__switch === 1) {
			return Outcome::Failure($o->params[0]);
		}
	}

	/**
	 *  Returns `true` if the outcome is `Success`
	 * 
	 * @param Outcome $outcome
	 * 
	 * @return bool
	 */
	public static function isSuccess ($outcome) {
		if ($outcome->index === 0) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 *  Transforms the outcome with a transform function
	 *  Different from `flatMap`, the transform function of `map` returns a plain value
	 * 
	 * @param Outcome $outcome
	 * @param \Closure $transform
	 * 
	 * @return Outcome
	 */
	public static function map ($outcome, $transform) {
		$__hx__switch = ($outcome->index);
		if ($__hx__switch === 0) {
			return Outcome::Success($transform($outcome->params[0]));
		} else if ($__hx__switch === 1) {
			return Outcome::Failure($outcome->params[0]);
		}
	}

	/**
	 * @param Outcome $outcome
	 * @param \Closure $f
	 * 
	 * @return FutureObject
	 */
	public static function next ($outcome, $f) {
		$__hx__switch = ($outcome->index);
		if ($__hx__switch === 0) {
			return $f($outcome->params[0]);
		} else if ($__hx__switch === 1) {
			return new SyncFuture(new LazyConst(Outcome::Failure($outcome->params[0])));
		}
	}

	/**
	 *  Extracts the value if the option is `Success`, otherwise `null`
	 * 
	 * @param Outcome $outcome
	 * 
	 * @return mixed
	 */
	public static function orNull ($outcome) {
		$__hx__switch = ($outcome->index);
		if ($__hx__switch === 0) {
			return $outcome->params[0];
		} else if ($__hx__switch === 1) {
			return null;
		}
	}

	/**
	 *  Extracts the value if the option is `Success`, uses the fallback `Outcome` otherwise
	 * 
	 * @param Outcome $outcome
	 * @param LazyObject $fallback
	 * 
	 * @return Outcome
	 */
	public static function orTry ($outcome, $fallback) {
		$__hx__switch = ($outcome->index);
		if ($__hx__switch === 0) {
			return $outcome;
		} else if ($__hx__switch === 1) {
			return $fallback->get();
		}
	}

	/**
	 *  Extracts the value if the option is `Success`, uses the fallback value otherwise
	 * 
	 * @param Outcome $outcome
	 * @param LazyObject $fallback
	 * 
	 * @return mixed
	 */
	public static function orUse ($outcome, $fallback) {
		$__hx__switch = ($outcome->index);
		if ($__hx__switch === 0) {
			return $outcome->params[0];
		} else if ($__hx__switch === 1) {
			return $fallback->get();
		}
	}

	/**
	 *  Extracts the value if the outcome is `Success`, throws the `Failure` contents otherwise
	 * 
	 * @param Outcome $outcome
	 * 
	 * @return mixed
	 */
	public static function sure ($outcome) {
		$__hx__switch = ($outcome->index);
		if ($__hx__switch === 0) {
			return $outcome->params[0];
		} else if ($__hx__switch === 1) {
			$_g = $outcome->params[0];
			$_g1 = TypedError::asError($_g);
			if ($_g1 === null) {
				throw Exception::thrown($_g);
			} else {
				return $_g1->throwSelf();
			}
		}
	}

	/**
	 *  Like `map` but with a plain value instead of a transform function, thus discarding the orginal result
	 * 
	 * @param Outcome $outcome
	 * @param mixed $v
	 * 
	 * @return Outcome
	 */
	public static function swap ($outcome, $v) {
		$__hx__switch = ($outcome->index);
		if ($__hx__switch === 0) {
			return Outcome::Success($v);
		} else if ($__hx__switch === 1) {
			return Outcome::Failure($outcome->params[0]);
		}
	}

	/**
	 *  Creates an `Option` from this `Outcome`, discarding the `Failure` information
	 * 
	 * @param Outcome $outcome
	 * 
	 * @return DsOption
	 */
	public static function toOption ($outcome) {
		$__hx__switch = ($outcome->index);
		if ($__hx__switch === 0) {
			return DsOption::Some($outcome->params[0]);
		} else if ($__hx__switch === 1) {
			return DsOption::None();
		}
	}

	/**
	 *  Creates an `Outcome` from an `Option`, with made-up `Failure` information
	 * 
	 * @param DsOption $option
	 * @param object $pos
	 * 
	 * @return Outcome
	 */
	public static function toOutcome ($option, $pos = null) {
		$__hx__switch = ($option->index);
		if ($__hx__switch === 0) {
			return Outcome::Success($option->params[0]);
		} else if ($__hx__switch === 1) {
			return Outcome::Failure(new TypedError(404, "Some value expected but none found in " . ($pos->fileName??'null') . "@line " . ($pos->lineNumber??'null'), new HxAnon([
				"fileName" => "tink/core/Outcome.hx",
				"lineNumber" => 48,
				"className" => "tink.core.OutcomeTools",
				"methodName" => "toOutcome",
			])));
		}
	}
}

Boot::registerClass(OutcomeTools::class, 'tink.core.OutcomeTools');
