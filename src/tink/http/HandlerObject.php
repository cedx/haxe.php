<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace tink\http;

use \php\Boot;
use \tink\core\FutureObject;

interface HandlerObject {
	/**
	 * @param IncomingRequest $req
	 * 
	 * @return FutureObject
	 */
	public function process ($req) ;
}

Boot::registerClass(HandlerObject::class, 'tink.http.HandlerObject');
