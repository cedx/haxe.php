<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace tink\http\_Client;

use \tink\http\Fetch;
use \php\Boot;
use \tink\http\ClientObject;
use \tink\core\FutureObject;

final class Client_Impl_ {
	/**
	 * @param ClientObject $this
	 * @param object $pipeline
	 * 
	 * @return ClientObject
	 */
	public static function augment ($this1, $pipeline) {
		return CustomClient::create($this1, $pipeline->before, $pipeline->after);
	}

	/**
	 * @param object $url
	 * @param object $options
	 * 
	 * @return FutureObject
	 */
	public static function fetch ($url, $options = null) {
		return Fetch::fetch($url, $options);
	}
}

Boot::registerClass(Client_Impl_::class, 'tink.http._Client.Client_Impl_');
