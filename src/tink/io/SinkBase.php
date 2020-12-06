<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace tink\io;

use \php\Boot;
use \haxe\Exception;
use \tink\streams\StreamObject;
use \tink\core\FutureObject;

class SinkBase implements SinkObject {

	/**
	 * @param StreamObject $source
	 * @param object $options
	 * 
	 * @return FutureObject
	 */
	public function consume ($source, $options) {
		throw Exception::thrown("not implemented");
	}

	/**
	 * @return bool
	 */
	public function get_sealed () {
		return true;
	}
}

Boot::registerClass(SinkBase::class, 'tink.io.SinkBase');
Boot::registerGetters('tink\\io\\SinkBase', [
	'sealed' => true
]);
