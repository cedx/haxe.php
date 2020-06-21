<?php
/**
 * Generated by Haxe 4.1.2
 */

namespace haxe\macro;

use \php\Boot;
use \php\_Boot\HxEnum;

class Message extends HxEnum {
	/**
	 * @param string $msg
	 * @param object $pos
	 * 
	 * @return Message
	 */
	static public function Info ($msg, $pos) {
		return new Message('Info', 0, [$msg, $pos]);
	}

	/**
	 * @param string $msg
	 * @param object $pos
	 * 
	 * @return Message
	 */
	static public function Warning ($msg, $pos) {
		return new Message('Warning', 1, [$msg, $pos]);
	}

	/**
	 * Returns array of (constructorIndex => constructorName)
	 *
	 * @return string[]
	 */
	static public function __hx__list () {
		return [
			0 => 'Info',
			1 => 'Warning',
		];
	}

	/**
	 * Returns array of (constructorName => parametersCount)
	 *
	 * @return int[]
	 */
	static public function __hx__paramsCount () {
		return [
			'Info' => 2,
			'Warning' => 2,
		];
	}
}

Boot::registerClass(Message::class, 'haxe.macro.Message');
