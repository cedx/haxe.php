<?php
/**
 * Generated by Haxe 4.1.2
 */

namespace tink\cli\_Prompt;

use \php\Boot;
use \tink\cli\PromptTypeBase;

final class PromptType_Impl_ {
	/**
	 * @param string $v
	 * 
	 * @return PromptTypeBase
	 */
	public static function ofString ($v) {
		return PromptTypeBase::Simple($v);
	}
}

Boot::registerClass(PromptType_Impl_::class, 'tink.cli._Prompt.PromptType_Impl_');
