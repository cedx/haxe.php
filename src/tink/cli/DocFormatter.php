<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace tink\cli;

use \php\Boot;

interface DocFormatter {
	/**
	 * @param object $spec
	 * 
	 * @return mixed
	 */
	public function format ($spec) ;
}

Boot::registerClass(DocFormatter::class, 'tink.cli.DocFormatter');
