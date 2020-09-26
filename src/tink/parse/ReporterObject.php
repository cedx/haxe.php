<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace tink\parse;

use \php\Boot;

interface ReporterObject {
	/**
	 * @param string $message
	 * @param mixed $pos
	 * 
	 * @return mixed
	 */
	public function makeError ($message, $pos) ;

	/**
	 * @param int $from
	 * @param int $to
	 * 
	 * @return mixed
	 */
	public function makePos ($from, $to) ;
}

Boot::registerClass(ReporterObject::class, 'tink.parse.ReporterObject');