<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace haxe\io;

use \haxe\io\_BytesData\Container;
use \php\Boot;
use \haxe\Exception;
use \haxe\NativeStackTrace;

/**
 * An Output is an abstract write. A specific output implementation will only
 * have to override the `writeByte` and maybe the `write`, `flush` and `close`
 * methods. See `File.write` and `String.write` for two ways of creating an
 * Output.
 */
class Output {
	/**
	 * @var bool
	 * Endianness (word byte order) used when writing numbers.
	 * If `true`, big-endian is used, otherwise `little-endian` is used.
	 */
	public $bigEndian;

	/**
	 * Close the output.
	 * Behaviour while writing after calling this method is unspecified.
	 * 
	 * @return void
	 */
	public function close () {
	}

	/**
	 * Flush any buffered data.
	 * 
	 * @return void
	 */
	public function flush () {
	}

	/**
	 * Inform that we are about to write at least `nbytes` bytes.
	 * The underlying implementation can allocate proper working space depending
	 * on this information, or simply ignore it. This is not a mandatory call
	 * but a tip and is only used in some specific cases.
	 * 
	 * @param int $nbytes
	 * 
	 * @return void
	 */
	public function prepare ($nbytes) {
	}

	/**
	 * @param bool $b
	 * 
	 * @return bool
	 */
	public function set_bigEndian ($b) {
		$this->bigEndian = $b;
		return $b;
	}

	/**
	 * Write all bytes stored in `s`.
	 * 
	 * @param Bytes $s
	 * 
	 * @return void
	 */
	public function write ($s) {
		$l = $s->length;
		$p = 0;
		while ($l > 0) {
			$k = $this->writeBytes($s, $p, $l);
			if ($k === 0) {
				throw Exception::thrown(Error::Blocked());
			}
			$p += $k;
			$l -= $k;
		}
	}

	/**
	 * Write one byte.
	 * 
	 * @param int $c
	 * 
	 * @return void
	 */
	public function writeByte ($c) {
		throw Exception::thrown("Not implemented");
	}

	/**
	 * Write `len` bytes from `s` starting by position specified by `pos`.
	 * Returns the actual length of written data that can differ from `len`.
	 * See `writeFullBytes` that tries to write the exact amount of specified bytes.
	 * 
	 * @param Bytes $s
	 * @param int $pos
	 * @param int $len
	 * 
	 * @return int
	 */
	public function writeBytes ($s, $pos, $len) {
		if (($pos < 0) || ($len < 0) || (($pos + $len) > $s->length)) {
			throw Exception::thrown(Error::OutsideBounds());
		}
		$b = $s->b;
		$k = $len;
		while ($k > 0) {
			$this->writeByte(\ord($b->s[$pos]));
			++$pos;
			--$k;
		}
		return $len;
	}

	/**
	 * Write `x` as 64-bit double-precision floating point number.
	 * Endianness is specified by the `bigEndian` property.
	 * 
	 * @param float $x
	 * 
	 * @return void
	 */
	public function writeDouble ($x) {
		$i64 = FPHelper::doubleToI64($x);
		if ($this->bigEndian) {
			$this->writeInt32($i64->high);
			$this->writeInt32($i64->low);
		} else {
			$this->writeInt32($i64->low);
			$this->writeInt32($i64->high);
		}
	}

	/**
	 * Write `x` as 32-bit floating point number.
	 * Endianness is specified by the `bigEndian` property.
	 * 
	 * @param float $x
	 * 
	 * @return void
	 */
	public function writeFloat ($x) {
		$this->writeInt32(\unpack("l", \pack("f", $x))[1]);
	}

	/**
	 * Write `len` bytes from `s` starting by position specified by `pos`.
	 * Unlike `writeBytes`, this method tries to write the exact `len` amount of bytes.
	 * 
	 * @param Bytes $s
	 * @param int $pos
	 * @param int $len
	 * 
	 * @return void
	 */
	public function writeFullBytes ($s, $pos, $len) {
		while ($len > 0) {
			$k = $this->writeBytes($s, $pos, $len);
			$pos += $k;
			$len -= $k;
		}
	}

	/**
	 * Read all available data from `i` and write it.
	 * The `bufsize` optional argument specifies the size of chunks by
	 * which data is read and written. Its default value is 4096.
	 * 
	 * @param Input $i
	 * @param int $bufsize
	 * 
	 * @return void
	 */
	public function writeInput ($i, $bufsize = null) {
		if ($bufsize === null) {
			$bufsize = 4096;
		}
		$buf = Bytes::alloc($bufsize);
		try {
			while (true) {
				$len = $i->readBytes($buf, 0, $bufsize);
				if ($len === 0) {
					throw Exception::thrown(Error::Blocked());
				}
				$p = 0;
				while ($len > 0) {
					$k = $this->writeBytes($buf, $p, $len);
					if ($k === 0) {
						throw Exception::thrown(Error::Blocked());
					}
					$p += $k;
					$len -= $k;
				}
			}
		} catch(\Throwable $_g) {
			NativeStackTrace::saveStack($_g);
			if (!(Exception::caught($_g)->unwrap() instanceof Eof)) {
				throw $_g;
			}
		}
	}

	/**
	 * Write `x` as 16-bit signed integer.
	 * Endianness is specified by the `bigEndian` property.
	 * 
	 * @param int $x
	 * 
	 * @return void
	 */
	public function writeInt16 ($x) {
		if (($x < -32768) || ($x >= 32768)) {
			throw Exception::thrown(Error::Overflow());
		}
		$this->writeUInt16($x & 65535);
	}

	/**
	 * Write `x` as 24-bit signed integer.
	 * Endianness is specified by the `bigEndian` property.
	 * 
	 * @param int $x
	 * 
	 * @return void
	 */
	public function writeInt24 ($x) {
		if (($x < -8388608) || ($x >= 8388608)) {
			throw Exception::thrown(Error::Overflow());
		}
		$this->writeUInt24($x & 16777215);
	}

	/**
	 * Write `x` as 32-bit signed integer.
	 * Endianness is specified by the `bigEndian` property.
	 * 
	 * @param int $x
	 * 
	 * @return void
	 */
	public function writeInt32 ($x) {
		if ($this->bigEndian) {
			$this->writeByte(Boot::shiftRightUnsigned($x, 24));
			$this->writeByte(($x >> 16) & 255);
			$this->writeByte(($x >> 8) & 255);
			$this->writeByte($x & 255);
		} else {
			$this->writeByte($x & 255);
			$this->writeByte(($x >> 8) & 255);
			$this->writeByte(($x >> 16) & 255);
			$this->writeByte(Boot::shiftRightUnsigned($x, 24));
		}
	}

	/**
	 * Write `x` as 8-bit signed integer.
	 * 
	 * @param int $x
	 * 
	 * @return void
	 */
	public function writeInt8 ($x) {
		if (($x < -128) || ($x >= 128)) {
			throw Exception::thrown(Error::Overflow());
		}
		$this->writeByte($x & 255);
	}

	/**
	 * Write `s` string.
	 * 
	 * @param string $s
	 * @param Encoding $encoding
	 * 
	 * @return void
	 */
	public function writeString ($s, $encoding = null) {
		$b = \strlen($s);
		$b1 = new Bytes($b, new Container($s));
		$this->writeFullBytes($b1, 0, $b1->length);
	}

	/**
	 * Write `x` as 16-bit unsigned integer.
	 * Endianness is specified by the `bigEndian` property.
	 * 
	 * @param int $x
	 * 
	 * @return void
	 */
	public function writeUInt16 ($x) {
		if (($x < 0) || ($x >= 65536)) {
			throw Exception::thrown(Error::Overflow());
		}
		if ($this->bigEndian) {
			$this->writeByte($x >> 8);
			$this->writeByte($x & 255);
		} else {
			$this->writeByte($x & 255);
			$this->writeByte($x >> 8);
		}
	}

	/**
	 * Write `x` as 24-bit unsigned integer.
	 * Endianness is specified by the `bigEndian` property.
	 * 
	 * @param int $x
	 * 
	 * @return void
	 */
	public function writeUInt24 ($x) {
		if (($x < 0) || ($x >= 16777216)) {
			throw Exception::thrown(Error::Overflow());
		}
		if ($this->bigEndian) {
			$this->writeByte($x >> 16);
			$this->writeByte(($x >> 8) & 255);
			$this->writeByte($x & 255);
		} else {
			$this->writeByte($x & 255);
			$this->writeByte(($x >> 8) & 255);
			$this->writeByte($x >> 16);
		}
	}
}

Boot::registerClass(Output::class, 'haxe.io.Output');
Boot::registerSetters('haxe\\io\\Output', [
	'bigEndian' => true
]);
