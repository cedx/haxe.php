<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace sys\io\_Process;

use \haxe\io\_BytesData\Container;
use \php\Boot;
use \haxe\Exception;
use \haxe\io\Eof;
use \haxe\io\Error;
use \haxe\io\Input;
use \haxe\io\Bytes;

class ReadablePipe extends Input {
	/**
	 * @var mixed
	 */
	public $pipe;
	/**
	 * @var Bytes
	 */
	public $tmpBytes;

	/**
	 * @param mixed $pipe
	 * 
	 * @return void
	 */
	public function __construct ($pipe) {
		$this->pipe = $pipe;
		$this->tmpBytes = Bytes::alloc(1);
	}

	/**
	 * @return void
	 */
	public function close () {
		\fclose($this->pipe);
	}

	/**
	 * @return int
	 */
	public function readByte () {
		if ($this->readBytes($this->tmpBytes, 0, 1) === 0) {
			throw Exception::thrown(Error::Blocked());
		}
		return \ord($this->tmpBytes->b->s[0]);
	}

	/**
	 * @param Bytes $s
	 * @param int $pos
	 * @param int $len
	 * 
	 * @return int
	 */
	public function readBytes ($s, $pos, $len) {
		if (\feof($this->pipe)) {
			throw Exception::thrown(new Eof());
		}
		$result = \fread($this->pipe, $len);
		if ($result === "") {
			throw Exception::thrown(new Eof());
		}
		if ($result === false) {
			throw Exception::thrown(Error::Custom("Failed to read process output"));
		}
		$result1 = $result;
		$bytes = \strlen($result1);
		$bytes1 = new Bytes($bytes, new Container($result1));
		$len = \strlen($result1);
		if (($pos < 0) || ($len < 0) || (($pos + $len) > $s->length) || ($len > $bytes1->length)) {
			throw Exception::thrown(Error::OutsideBounds());
		} else {
			$this1 = $s->b;
			$src = $bytes1->b;
			$this1->s = ((\substr($this1->s, 0, $pos) . \substr($src->s, 0, $len)) . \substr($this1->s, $pos + $len));
		}
		return \strlen($result1);
	}
}

Boot::registerClass(ReadablePipe::class, 'sys.io._Process.ReadablePipe');
