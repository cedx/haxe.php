<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace tink\streams\_Stream;

use \tink\core\_Lazy\LazyFunc;
use \tink\streams\RegroupStatus;
use \php\Boot;
use \tink\streams\StreamObject;
use \tink\streams\Handled;
use \tink\streams\Empty_hx;

class RegroupStream extends CompoundStream {
	/**
	 * @param StreamObject $source
	 * @param object $f
	 * @param StreamObject $prev
	 * 
	 * @return void
	 */
	public function __construct ($source, $f, $prev = null) {
		if ($prev === null) {
			$prev = Empty_hx::$inst;
		}
		$ret = null;
		$terminated = false;
		$buf = new \Array_hx();
		parent::__construct(\Array_hx::wrap([
			$prev,
			Stream_Impl_::flatten($source->forEach(Handler_Impl_::ofUnknown(function ($item) use (&$terminated, &$f, &$buf, &$ret) {
				$buf->arr[$buf->length++] = $item;
				return $f->apply($buf, RegroupStatus::Flowing())->map(function ($o) use (&$terminated, &$ret) {
					$__hx__switch = ($o->index);
					if ($__hx__switch === 0) {
						$ret = $o->params[0];
						return Handled::Finish();
					} else if ($__hx__switch === 1) {
						$_g = $o->params[0];
						$ret = ($_g->index === 0 ? $_g->params[0] : (new LazyFunc(Boot::getStaticClosure(Empty_hx::class, 'make')))->get());
						$terminated = true;
						return Handled::Finish();
					} else if ($__hx__switch === 2) {
						return Handled::Resume();
					} else if ($__hx__switch === 3) {
						return Handled::Clog($o->params[0]);
					}
				})->gather();
			}))->map(function ($o) use (&$terminated, &$f, &$buf, &$ret) {
				$__hx__switch = ($o->index);
				if ($__hx__switch === 0) {
					if ($terminated) {
						return $ret;
					} else {
						return new RegroupStream($o->params[0], $f, $ret);
					}
				} else if ($__hx__switch === 1) {
					return new ErrorStream($o->params[0]);
				} else if ($__hx__switch === 2) {
					return Stream_Impl_::ofError($o->params[0]);
				} else if ($__hx__switch === 3) {
					if ($buf->length === 0) {
						return Empty_hx::$inst;
					} else {
						return Stream_Impl_::flatten($f->apply($buf, RegroupStatus::Ended())->map(function ($o) {
							$__hx__switch = ($o->index);
							if ($__hx__switch === 0) {
								return $o->params[0];
							} else if ($__hx__switch === 1) {
								$_g = $o->params[0];
								if ($_g->index === 0) {
									return $_g->params[0];
								} else {
									return (new LazyFunc(Boot::getStaticClosure(Empty_hx::class, 'make')))->get();
								}
							} else if ($__hx__switch === 2) {
								return Empty_hx::$inst;
							} else if ($__hx__switch === 3) {
								return Stream_Impl_::ofError($o->params[0]);
							}
						})->gather());
					}
				}
			})->gather()),
		]));
	}
}

Boot::registerClass(RegroupStream::class, 'tink.streams._Stream.RegroupStream');
