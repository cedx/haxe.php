<?php
/**
 * Generated by Haxe 4.1.1
 */

namespace sys\io;

use \sys\io\_Process\WritablePipe;
use \php\Boot;
use \haxe\Exception;
use \haxe\io\Output;
use \haxe\io\Error;
use \haxe\io\Input;
use \haxe\SysTools;
use \sys\io\_Process\ReadablePipe;

class Process {
	/**
	 * @var int
	 */
	public $_exitCode;
	/**
	 * @var int
	 */
	public $pid;
	/**
	 * @var mixed
	 */
	public $pipes;
	/**
	 * @var mixed
	 */
	public $process;
	/**
	 * @var bool
	 */
	public $running;
	/**
	 * @var Input
	 */
	public $stderr;
	/**
	 * @var Output
	 */
	public $stdin;
	/**
	 * @var Input
	 */
	public $stdout;

	/**
	 * @param string $cmd
	 * @param \Array_hx $args
	 * @param bool $detached
	 * 
	 * @return void
	 */
	public function __construct ($cmd, $args = null, $detached = null) {
		$this->_exitCode = -1;
		$this->running = true;
		$this->pid = -1;
		if ($detached) {
			throw Exception::thrown("Detached process is not supported on this platform");
		}
		$descriptors = [["pipe", "r"], ["pipe", "w"], ["pipe", "w"]];
		$result = proc_open($this->buildCmd($cmd, $args), $descriptors, $this->pipes);
		if ($result === false) {
			throw Exception::thrown(Error::Custom("Failed to start process: " . ($cmd??'null')));
		}
		$this->process = $result;
		$this->updateStatus();
		$this->stdin = new WritablePipe($this->pipes[0]);
		$this->stdout = new ReadablePipe($this->pipes[1]);
		$this->stderr = new ReadablePipe($this->pipes[2]);
	}

	/**
	 * @param string $cmd
	 * @param \Array_hx $args
	 * 
	 * @return string
	 */
	public function buildCmd ($cmd, $args = null) {
		if ($args === null) {
			return $cmd;
		}
		if (\Sys::systemName() === "Windows") {
			$_this = (\Array_hx::wrap([\StringTools::replace($cmd, "/", "\\")]))->concat($args);
			$escapeMetaCharacters = true;
			$f = function ($argument) use (&$escapeMetaCharacters) {
				return SysTools::quoteWinArg($argument, $escapeMetaCharacters);
			};
			$result = [];
			$data = $_this->arr;
			$_g_current = 0;
			$_g_length = count($data);
			$_g_data = $data;
			while ($_g_current < $_g_length) {
				$item = $_g_data[$_g_current++];
				$result[] = $f($item);
			}
			return \Array_hx::wrap($result)->join(" ");
		} else {
			$_this = (\Array_hx::wrap([$cmd]))->concat($args);
			$f = Boot::getStaticClosure(SysTools::class, 'quoteUnixArg');
			$result = [];
			$data = $_this->arr;
			$_g_current = 0;
			$_g_length = count($data);
			$_g_data = $data;
			while ($_g_current < $_g_length) {
				$item = $_g_data[$_g_current++];
				$result[] = $f($item);
			}
			return \Array_hx::wrap($result)->join(" ");
		}
	}

	/**
	 * @return void
	 */
	public function close () {
		if (!$this->running) {
			return;
		}
		$data = $this->pipes;
		$_g_current = 0;
		$_g_length = count($data);
		$_g_data = $data;
		while ($_g_current < $_g_length) {
			$pipe = $_g_data[$_g_current++];
			fclose($pipe);
		}
		proc_close($this->process);
	}

	/**
	 * @param bool $block
	 * 
	 * @return int
	 */
	public function exitCode ($block = true) {
		if ($block === null) {
			$block = true;
		}
		if (!$block) {
			$this->updateStatus();
			if ($this->running) {
				return null;
			} else {
				return $this->_exitCode;
			}
		}
		while ($this->running) {
			$arr = [$this->process];
			@stream_select($arr, $arr, $arr, null);
			$this->updateStatus();
		}
		return $this->_exitCode;
	}

	/**
	 * @return int
	 */
	public function getPid () {
		return $this->pid;
	}

	/**
	 * @return void
	 */
	public function kill () {
		proc_terminate($this->process);
	}

	/**
	 * @return void
	 */
	public function updateStatus () {
		if (!$this->running) {
			return;
		}
		$status = proc_get_status($this->process);
		if ($status === false) {
			throw Exception::thrown(Error::Custom("Failed to obtain process status"));
		}
		$status1 = $status;
		$this->pid = $status1["pid"];
		$this->running = $status1["running"];
		$this->_exitCode = $status1["exitcode"];
	}
}

Boot::registerClass(Process::class, 'sys.io.Process');
