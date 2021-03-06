<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace tink;

use \php\Boot;
use \tink\core\Outcome as CoreOutcome;

class Cli {
	/**
	 * @param CoreOutcome $result
	 * 
	 * @return void
	 */
	public static function exit ($result) {
		$__hx__switch = ($result->index);
		if ($__hx__switch === 0) {
			exit(0);
		} else if ($__hx__switch === 1) {
			$_g = $result->params[0];
			$message = $_g->message;
			if ($_g->data !== null) {
				$message = ($message??'null') . ", " . (\Std::string($_g->data)??'null');
			}
			echo((\Std::string($message)??'null') . \PHP_EOL);
			exit($_g->code);
		}
	}
}

Boot::registerClass(Cli::class, 'tink.Cli');
