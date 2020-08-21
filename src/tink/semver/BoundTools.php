<?php
/**
 * Generated by Haxe 4.1.3
 */

namespace tink\semver;

use \php\Boot;
use \tink\semver\_Version\Version_Impl_;

class BoundTools {
	/**
	 * @param Bound $a
	 * @param Bound $b
	 * 
	 * @return bool
	 */
	public static function isLowerThan ($a, $b) {
		$__hx__switch = ($a->index);
		if ($__hx__switch === 1) {
			$_g = $a->params[0];
			$__hx__switch = ($b->index);
			if ($__hx__switch === 1) {
				$_g1 = $b->params[0];
				if (Version_Impl_::eq($_g, $_g1)) {
					return false;
				} else if (Version_Impl_::gt($_g, $_g1)) {
					return false;
				} else {
					return true;
				}
			} else if ($__hx__switch === 2) {
				if (Version_Impl_::gt($_g, $b->params[0])) {
					return false;
				} else {
					return true;
				}
			} else {
				return true;
			}
		} else if ($__hx__switch === 2) {
			$_g = $a->params[0];
			$__hx__switch = ($b->index);
			if ($__hx__switch === 1) {
				$_g1 = $b->params[0];
				if (Version_Impl_::eq($_g, $_g1)) {
					return false;
				} else if (Version_Impl_::gt($_g, $_g1)) {
					return false;
				} else {
					return true;
				}
			} else if ($__hx__switch === 2) {
				if (Version_Impl_::gt($_g, $b->params[0])) {
					return false;
				} else {
					return true;
				}
			} else {
				return true;
			}
		} else {
			return true;
		}
	}

	/**
	 * @param Bound $a
	 * @param Bound $b
	 * @param ExtremumKind $kind
	 * 
	 * @return Bound
	 */
	public static function max ($a, $b, $kind) {
		$__hx__switch = ($a->index);
		if ($__hx__switch === 0) {
			if ($kind === ExtremumKind::Upper()) {
				return Bound::Unbounded();
			} else {
				return $b;
			}
		} else if ($__hx__switch === 1) {
			$_g = $a->params[0];
			$__hx__switch = ($b->index);
			if ($__hx__switch === 0) {
				if ($kind === ExtremumKind::Upper()) {
					return Bound::Unbounded();
				} else {
					return $a;
				}
			} else if ($__hx__switch === 1) {
				if (Version_Impl_::gt($_g, $b->params[0])) {
					return $a;
				} else {
					return $b;
				}
			} else if ($__hx__switch === 2) {
				$_g1 = $b->params[0];
				if (Version_Impl_::eq($_g, $_g1)) {
					if ($kind === ExtremumKind::Upper()) {
						return $b;
					} else {
						return $a;
					}
				} else if (Version_Impl_::gt($_g, $_g1)) {
					return $a;
				} else {
					return $b;
				}
			}
		} else if ($__hx__switch === 2) {
			$_g = $a->params[0];
			$__hx__switch = ($b->index);
			if ($__hx__switch === 0) {
				if ($kind === ExtremumKind::Upper()) {
					return Bound::Unbounded();
				} else {
					return $a;
				}
			} else if ($__hx__switch === 1) {
				$_g1 = $b->params[0];
				if (Version_Impl_::eq($_g1, $_g)) {
					if ($kind === ExtremumKind::Upper()) {
						return $a;
					} else {
						return $b;
					}
				} else if (Version_Impl_::gt($_g, $_g1)) {
					return $a;
				} else {
					return $b;
				}
			} else if ($__hx__switch === 2) {
				if (Version_Impl_::gt($_g, $b->params[0])) {
					return $a;
				} else {
					return $b;
				}
			}
		}
	}

	/**
	 * @param Bound $a
	 * @param Bound $b
	 * @param ExtremumKind $kind
	 * 
	 * @return Bound
	 */
	public static function min ($a, $b, $kind) {
		$__hx__switch = ($a->index);
		if ($__hx__switch === 0) {
			if ($kind === ExtremumKind::Lower()) {
				return Bound::Unbounded();
			} else {
				return $b;
			}
		} else if ($__hx__switch === 1) {
			$_g = $a->params[0];
			$__hx__switch = ($b->index);
			if ($__hx__switch === 0) {
				if ($kind === ExtremumKind::Lower()) {
					return Bound::Unbounded();
				} else {
					return $a;
				}
			} else if ($__hx__switch === 1) {
				if (Version_Impl_::lt($_g, $b->params[0])) {
					return $a;
				} else {
					return $b;
				}
			} else if ($__hx__switch === 2) {
				$_g1 = $b->params[0];
				if (Version_Impl_::eq($_g, $_g1)) {
					if ($kind === ExtremumKind::Lower()) {
						return $b;
					} else {
						return $a;
					}
				} else if (Version_Impl_::lt($_g, $_g1)) {
					return $a;
				} else {
					return $b;
				}
			}
		} else if ($__hx__switch === 2) {
			$_g = $a->params[0];
			$__hx__switch = ($b->index);
			if ($__hx__switch === 0) {
				if ($kind === ExtremumKind::Lower()) {
					return Bound::Unbounded();
				} else {
					return $a;
				}
			} else if ($__hx__switch === 1) {
				$_g1 = $b->params[0];
				if (Version_Impl_::eq($_g1, $_g)) {
					if ($kind === ExtremumKind::Lower()) {
						return $a;
					} else {
						return $b;
					}
				} else if (Version_Impl_::lt($_g, $_g1)) {
					return $a;
				} else {
					return $b;
				}
			} else if ($__hx__switch === 2) {
				if (Version_Impl_::lt($_g, $b->params[0])) {
					return $a;
				} else {
					return $b;
				}
			}
		}
	}
}

Boot::registerClass(BoundTools::class, 'tink.semver.BoundTools');
