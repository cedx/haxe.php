<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace tink\streams;

use \tink\streams\_Stream\RegroupStream;
use \php\Boot;
use \haxe\Exception;
use \tink\streams\_Stream\Handler_Impl_;
use \tink\core\_Future\Future_Impl_;
use \tink\core\FutureObject;
use \tink\streams\_Stream\CompoundStream;

class StreamBase implements StreamObject {
	/**
	 * @var int
	 */
	public $retainCount;

	/**
	 * @return void
	 */
	public function __construct () {
		$this->retainCount = 0;
	}

	/**
	 * @param StreamObject $other
	 * 
	 * @return StreamObject
	 */
	public function append ($other) {
		if ($this->get_depleted()) {
			return $other;
		} else {
			return CompoundStream::of(\Array_hx::wrap([
				$this,
				$other,
			]));
		}
	}

	/**
	 * @param StreamObject $other
	 * 
	 * @return StreamObject
	 */
	public function blend ($other) {
		if ($this->get_depleted()) {
			return $other;
		} else {
			return new BlendStream($this, $other);
		}
	}

	/**
	 * @param \Array_hx $into
	 * 
	 * @return void
	 */
	public function decompose ($into) {
		if (!$this->get_depleted()) {
			$into->arr[$into->length++] = $this;
		}
	}

	/**
	 * @return void
	 */
	public function destroy () {
	}

	/**
	 * @param object $f
	 * 
	 * @return StreamObject
	 */
	public function filter ($f) {
		return $this->regroup($f);
	}

	/**
	 * @param \Closure $handler
	 * 
	 * @return FutureObject
	 */
	public function forEach ($handler) {
		throw Exception::thrown("not implemented");
	}

	/**
	 * @return bool
	 */
	public function get_depleted () {
		return false;
	}

	/**
	 * @param \Closure $rescue
	 * 
	 * @return StreamObject
	 */
	public function idealize ($rescue) {
		if ($this->get_depleted()) {
			return Empty_hx::$inst;
		} else {
			return new IdealizeStream($this, $rescue);
		}
	}

	/**
	 * @param object $f
	 * 
	 * @return StreamObject
	 */
	public function map ($f) {
		return $this->regroup($f);
	}

	/**
	 * @return FutureObject
	 */
	public function next () {
		throw Exception::thrown("not implemented");
	}

	/**
	 * @param StreamObject $other
	 * 
	 * @return StreamObject
	 */
	public function prepend ($other) {
		if ($this->get_depleted()) {
			return $other;
		} else {
			return CompoundStream::of(\Array_hx::wrap([
				$other,
				$this,
			]));
		}
	}

	/**
	 * @param mixed $initial
	 * @param \Closure $reducer
	 * 
	 * @return FutureObject
	 */
	public function reduce ($initial, $reducer) {
		$_gthis = $this;
		return Future_Impl_::async(function ($cb) use (&$reducer, &$_gthis, &$initial) {
			$_gthis->forEach(Handler_Impl_::ofUnknown(function ($item) use (&$reducer, &$initial) {
				return $reducer($initial, $item)->map(function ($o) use (&$initial) {
					$__hx__switch = ($o->index);
					if ($__hx__switch === 0) {
						$initial = $o->params[0];
						return Handled::Resume();
					} else if ($__hx__switch === 1) {
						return Handled::Clog($o->params[0]);
					}
				})->gather();
			}))->handle(function ($c) use (&$initial, &$cb) {
				$__hx__switch = ($c->index);
				if ($__hx__switch === 0) {
					throw Exception::thrown("assert");
				} else if ($__hx__switch === 1) {
					$cb(Reduction::Crashed($c->params[0], $c->params[1]));
				} else if ($__hx__switch === 2) {
					$cb(Reduction::Failed($c->params[0]));
				} else if ($__hx__switch === 3) {
					$cb(Reduction::Reduced($initial));
				}
			});
		}, true);
	}

	/**
	 * @param object $f
	 * 
	 * @return StreamObject
	 */
	public function regroup ($f) {
		return new RegroupStream($this, $f);
	}

	/**
	 * @return \Closure
	 */
	public function retain () {
		$_gthis = $this;
		$this->retainCount++;
		$retained = true;
		return function () use (&$retained, &$_gthis) {
			if ($retained) {
				$retained = false;
				if (--$_gthis->retainCount === 0) {
					$_gthis->destroy();
				}
			}
		};
	}
}

Boot::registerClass(StreamBase::class, 'tink.streams.StreamBase');
Boot::registerGetters('tink\\streams\\StreamBase', [
	'depleted' => true
]);
