<?php
/**
 * Generated by Haxe 4.1.2
 */

namespace sys\io\_Process;

use \php\Boot;

final class ProcessPipes_Impl_ {

	/**
	 * @param mixed $this
	 * 
	 * @return mixed
	 */
	public static function get_stderr ($this1) {
		return $this1[2];
	}

	/**
	 * @param mixed $this
	 * 
	 * @return mixed
	 */
	public static function get_stdin ($this1) {
		return $this1[0];
	}

	/**
	 * @param mixed $this
	 * 
	 * @return mixed
	 */
	public static function get_stdout ($this1) {
		return $this1[1];
	}
}

Boot::registerClass(ProcessPipes_Impl_::class, 'sys.io._Process.ProcessPipes_Impl_');
Boot::registerGetters('sys\\io\\_Process\\ProcessPipes_Impl_', [
	'stderr' => true,
	'stdout' => true,
	'stdin' => true
]);
