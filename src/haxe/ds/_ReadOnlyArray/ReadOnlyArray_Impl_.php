<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace haxe\ds\_ReadOnlyArray;

use \php\Boot;

final class ReadOnlyArray_Impl_ {

	/**
	 * @param \Array_hx $this
	 * @param int $i
	 * 
	 * @return mixed
	 */
	public static function get ($this1, $i) {
		return ($this1->arr[$i] ?? null);
	}

	/**
	 * @param \Array_hx $this
	 * 
	 * @return int
	 */
	public static function get_length ($this1) {
		return $this1->length;
	}
}

Boot::registerClass(ReadOnlyArray_Impl_::class, 'haxe.ds._ReadOnlyArray.ReadOnlyArray_Impl_');
Boot::registerGetters('haxe\\ds\\_ReadOnlyArray\\ReadOnlyArray_Impl_', [
	'length' => true
]);
