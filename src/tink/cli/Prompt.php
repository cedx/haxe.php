<?php
/**
 * Generated by Haxe 4.1.3
 */

namespace tink\cli;

use \php\Boot;
use \tink\core\FutureObject;

interface Prompt {
	/**
	 * @param string $v
	 * 
	 * @return FutureObject
	 */
	public function print ($v) ;

	/**
	 * @param string $v
	 * 
	 * @return FutureObject
	 */
	public function println ($v) ;

	/**
	 * @param PromptTypeBase $type
	 * 
	 * @return FutureObject
	 */
	public function prompt ($type) ;
}

Boot::registerClass(Prompt::class, 'tink.cli.Prompt');
