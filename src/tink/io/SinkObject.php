<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace tink\io;

use \php\Boot;
use \tink\streams\StreamObject;
use \tink\core\FutureObject;

interface SinkObject {
	/**
	 * @param StreamObject $source
	 * @param object $options
	 * 
	 * @return FutureObject
	 */
	public function consume ($source, $options) ;

	/**
	 * @return bool
	 */
	public function get_sealed () ;
}

Boot::registerClass(SinkObject::class, 'tink.io.SinkObject');
Boot::registerGetters('tink\\io\\SinkObject', [
	'sealed' => true
]);
