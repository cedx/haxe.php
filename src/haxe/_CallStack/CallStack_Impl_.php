<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace haxe\_CallStack;

use \php\Boot;
use \haxe\Exception;
use \haxe\StackItem;
use \haxe\NativeStackTrace;

final class CallStack_Impl_ {

	/**
	 * @param \Array_hx $this
	 * 
	 * @return \Array_hx
	 */
	public static function asArray ($this1) {
		return $this1;
	}

	/**
	 * Return the call stack elements, or an empty array if not available.
	 * 
	 * @return \Array_hx
	 */
	public static function callStack () {
		return NativeStackTrace::toHaxe(\debug_backtrace(\DEBUG_BACKTRACE_IGNORE_ARGS));
	}

	/**
	 * Make a copy of the stack.
	 * 
	 * @param \Array_hx $this
	 * 
	 * @return \Array_hx
	 */
	public static function copy ($this1) {
		return (clone $this1);
	}

	/**
	 * @param StackItem $item1
	 * @param StackItem $item2
	 * 
	 * @return bool
	 */
	public static function equalItems ($item1, $item2) {
		if ($item1 === null) {
			if ($item2 === null) {
				return true;
			} else {
				return false;
			}
		} else {
			$__hx__switch = ($item1->index);
			if ($__hx__switch === 0) {
				if ($item2 === null) {
					return false;
				} else if ($item2->index === 0) {
					return true;
				} else {
					return false;
				}
			} else if ($__hx__switch === 1) {
				if ($item2 === null) {
					return false;
				} else if ($item2->index === 1) {
					return $item1->params[0] === $item2->params[0];
				} else {
					return false;
				}
			} else if ($__hx__switch === 2) {
				if ($item2 === null) {
					return false;
				} else if ($item2->index === 2) {
					if (($item1->params[1] === $item2->params[1]) && ($item1->params[2] === $item2->params[2]) && ($item1->params[3] === $item2->params[3])) {
						return CallStack_Impl_::equalItems($item1->params[0], $item2->params[0]);
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else if ($__hx__switch === 3) {
				if ($item2 === null) {
					return false;
				} else if ($item2->index === 3) {
					if ($item1->params[0] === $item2->params[0]) {
						return $item1->params[1] === $item2->params[1];
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else if ($__hx__switch === 4) {
				if ($item2 === null) {
					return false;
				} else if ($item2->index === 4) {
					return $item1->params[0] === $item2->params[0];
				} else {
					return false;
				}
			}
		}
	}

	/**
	 * Return the exception stack : this is the stack elements between
	 * the place the last exception was thrown and the place it was
	 * caught, or an empty array if not available.
	 * Set `fullStack` parameter to true in order to return the full exception stack.
	 * May not work if catch type was a derivative from `haxe.Exception`.
	 * 
	 * @param bool $fullStack
	 * 
	 * @return \Array_hx
	 */
	public static function exceptionStack ($fullStack = false) {
		if ($fullStack === null) {
			$fullStack = false;
		}
		$eStack = NativeStackTrace::toHaxe(NativeStackTrace::exceptionStack());
		return ($fullStack ? $eStack : CallStack_Impl_::subtract($eStack, CallStack_Impl_::callStack()));
	}

	/**
	 * @param Exception $e
	 * 
	 * @return string
	 */
	public static function exceptionToString ($e) {
		if ($e->get_previous() === null) {
			$tmp = "Exception: " . ($e->get_message()??'null');
			$tmp1 = $e->get_stack();
			return ($tmp??'null') . ((($tmp1 === null ? "null" : CallStack_Impl_::toString($tmp1)))??'null');
		}
		$result = "";
		$e1 = $e;
		$prev = null;
		while ($e1 !== null) {
			if ($prev === null) {
				$result1 = "Exception: " . ($e1->get_message()??'null');
				$tmp = $e1->get_stack();
				$result = ($result1??'null') . ((($tmp === null ? "null" : CallStack_Impl_::toString($tmp)))??'null') . ($result??'null');
			} else {
				$prevStack = CallStack_Impl_::subtract($e1->get_stack(), $prev->get_stack());
				$result = "Exception: " . ($e1->get_message()??'null') . ((($prevStack === null ? "null" : CallStack_Impl_::toString($prevStack)))??'null') . "\x0A\x0ANext " . ($result??'null');
			}
			$prev = $e1;
			$e1 = $e1->get_previous();
		}
		return $result;
	}

	/**
	 * @param \Array_hx $this
	 * @param int $index
	 * 
	 * @return StackItem
	 */
	public static function get ($this1, $index) {
		return ($this1->arr[$index] ?? null);
	}

	/**
	 * @param \Array_hx $this
	 * 
	 * @return int
	 */
	public static function get_length ($this1) {
		return $this1->length;
	}

	/**
	 * @param \StringBuf $b
	 * @param StackItem $s
	 * 
	 * @return void
	 */
	public static function itemToString ($b, $s) {
		$__hx__switch = ($s->index);
		if ($__hx__switch === 0) {
			$b->add("a C function");
		} else if ($__hx__switch === 1) {
			$b->add("module ");
			$b->add($s->params[0]);
		} else if ($__hx__switch === 2) {
			$_g = $s->params[3];
			$_g1 = $s->params[0];
			if ($_g1 !== null) {
				CallStack_Impl_::itemToString($b, $_g1);
				$b->add(" (");
			}
			$b->add($s->params[1]);
			$b->add(" line ");
			$b->add($s->params[2]);
			if ($_g !== null) {
				$b->add(" column ");
				$b->add($_g);
			}
			if ($_g1 !== null) {
				$b->add(")");
			}
		} else if ($__hx__switch === 3) {
			$_g = $s->params[0];
			$b->add(($_g === null ? "<unknown>" : $_g));
			$b->add(".");
			$b->add($s->params[1]);
		} else if ($__hx__switch === 4) {
			$b->add("local function #");
			$b->add($s->params[0]);
		}
	}

	/**
	 * Returns a range of entries of current stack from the beginning to the the
	 * common part of this and `stack`.
	 * 
	 * @param \Array_hx $this
	 * @param \Array_hx $stack
	 * 
	 * @return \Array_hx
	 */
	public static function subtract ($this1, $stack) {
		$startIndex = -1;
		$i = -1;
		while (++$i < $this1->length) {
			$_g = 0;
			$_g1 = $stack->length;
			while ($_g < $_g1) {
				if (CallStack_Impl_::equalItems(($this1->arr[$i] ?? null), ($stack->arr[$_g++] ?? null))) {
					if ($startIndex < 0) {
						$startIndex = $i;
					}
					++$i;
					if ($i >= $this1->length) {
						break;
					}
				} else {
					$startIndex = -1;
				}
			}
			if ($startIndex >= 0) {
				break;
			}
		}
		if ($startIndex >= 0) {
			return $this1->slice(0, $startIndex);
		} else {
			return $this1;
		}
	}

	/**
	 * Returns a representation of the stack as a printable string.
	 * 
	 * @param \Array_hx $stack
	 * 
	 * @return string
	 */
	public static function toString ($stack) {
		$b = new \StringBuf();
		$_g = 0;
		$_g1 = $stack;
		while ($_g < $_g1->length) {
			$s = ($_g1->arr[$_g++] ?? null);
			$b->add("\x0ACalled from ");
			CallStack_Impl_::itemToString($b, $s);
		}
		return $b->b;
	}
}

Boot::registerClass(CallStack_Impl_::class, 'haxe._CallStack.CallStack_Impl_');
Boot::registerGetters('haxe\\_CallStack\\CallStack_Impl_', [
	'length' => true
]);
