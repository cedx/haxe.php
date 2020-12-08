<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace asys\io;

use \php\_Boot\HxAnon;
use \tink\io\SinkObject;
use \php\Boot;
use \tink\io\std\InputSource;
use \tink\streams\StreamObject;
use \tink\io\_Worker\Worker_Impl_;
use \tink\core\FutureTrigger;
use \tink\io\_Sink\SinkYielding_Impl_;
use \haxe\io\Bytes;
use \tink\core\FutureObject;
use \sys\io\Process as IoProcess;

class Process {
	/**
	 * @var FutureTrigger
	 */
	public $exitTrigger;
	/**
	 * @var IoProcess
	 */
	public $process;
	/**
	 * @var StreamObject
	 */
	public $stderr;
	/**
	 * @var SinkObject
	 */
	public $stdin;
	/**
	 * @var StreamObject
	 */
	public $stdout;

	/**
	 * @param string $cmd
	 * @param \Array_hx $args
	 * 
	 * @return void
	 */
	public function __construct ($cmd, $args = null) {
		$this->exitTrigger = new FutureTrigger();
		$this->process = new IoProcess($cmd, $args);
		$this->stdin = SinkYielding_Impl_::ofOutput("stdin", $this->process->stdin);
		$input = $this->process->stderr;
		$options = null;
		$options = new HxAnon();
		$tmp = Worker_Impl_::ensure($options->worker);
		$_g = $options->chunkSize;
		$this->stderr = new InputSource("stderr", $input, $tmp, Bytes::alloc(($_g === null ? 65536 : $_g)), 0);
		$input = $this->process->stdout;
		$options = null;
		$options = new HxAnon();
		$tmp = Worker_Impl_::ensure($options->worker);
		$_g = $options->chunkSize;
		$this->stdout = new InputSource("stdout", $input, $tmp, Bytes::alloc(($_g === null ? 65536 : $_g)), 0);
		$this->exitTrigger->trigger($this->process->exitCode());
	}

	/**
	 * @return void
	 */
	public function close () {
		$this->process->close();
	}

	/**
	 * @return FutureObject
	 */
	public function exitCode () {
		return $this->exitTrigger;
	}

	/**
	 * @return int
	 */
	public function getPid () {
		return $this->process->getPid();
	}

	/**
	 * @return void
	 */
	public function kill () {
		$this->process->kill();
	}
}

Boot::registerClass(Process::class, 'asys.io.Process');