<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace haxe\zip;

use \haxe\zip\_InflateImpl\Window;
use \haxe\zip\_InflateImpl\State;
use \php\Boot;
use \haxe\Exception;
use \haxe\io\BytesBuffer;
use \haxe\io\Error;
use \haxe\io\Input;
use \haxe\crypto\Adler32;
use \haxe\io\Bytes;

/**
 * A pure Haxe implementation of the ZLIB Inflate algorithm which allows reading compressed data without any platform-specific support.
 */
class InflateImpl {
	/**
	 * @var \Array_hx
	 */
	static public $CODE_LENGTHS_POS;
	/**
	 * @var \Array_hx
	 */
	static public $DIST_BASE_VAL_TBL;
	/**
	 * @var \Array_hx
	 */
	static public $DIST_EXTRA_BITS_TBL;
	/**
	 * @var Huffman
	 */
	static public $FIXED_HUFFMAN = null;
	/**
	 * @var \Array_hx
	 */
	static public $LEN_BASE_VAL_TBL;
	/**
	 * @var \Array_hx
	 */
	static public $LEN_EXTRA_BITS_TBL;

	/**
	 * @var int
	 */
	public $bits;
	/**
	 * @var int
	 */
	public $dist;
	/**
	 * @var HuffTools
	 */
	public $htools;
	/**
	 * @var Huffman
	 */
	public $huffdist;
	/**
	 * @var Huffman
	 */
	public $huffman;
	/**
	 * @var Input
	 */
	public $input;
	/**
	 * @var bool
	 */
	public $isFinal;
	/**
	 * @var int
	 */
	public $len;
	/**
	 * @var \Array_hx
	 */
	public $lengths;
	/**
	 * @var int
	 */
	public $nbits;
	/**
	 * @var int
	 */
	public $needed;
	/**
	 * @var int
	 */
	public $outpos;
	/**
	 * @var Bytes
	 */
	public $output;
	/**
	 * @var State
	 */
	public $state;
	/**
	 * @var Window
	 */
	public $window;

	/**
	 * @param Input $i
	 * @param int $bufsize
	 * 
	 * @return Bytes
	 */
	public static function run ($i, $bufsize = 65536) {
		if ($bufsize === null) {
			$bufsize = 65536;
		}
		$buf = Bytes::alloc($bufsize);
		$output = new BytesBuffer();
		$inflate = new InflateImpl($i);
		while (true) {
			$len = $inflate->readBytes($buf, 0, $bufsize);
			if (($len < 0) || ($len > $buf->length)) {
				throw Exception::thrown(Error::OutsideBounds());
			} else {
				$output->b = ($output->b . \substr($buf->b->s, 0, $len));
			}
			if ($len < $bufsize) {
				break;
			}
		}
		return $output->getBytes();
	}

	/**
	 * @param Input $i
	 * @param bool $header
	 * @param bool $crc
	 * 
	 * @return void
	 */
	public function __construct ($i, $header = true, $crc = true) {
		if ($header === null) {
			$header = true;
		}
		if ($crc === null) {
			$crc = true;
		}
		$this->isFinal = false;
		$this->htools = new HuffTools();
		$this->huffman = $this->buildFixedHuffman();
		$this->huffdist = null;
		$this->len = 0;
		$this->dist = 0;
		$this->state = ($header ? State::Head() : State::Block());
		$this->input = $i;
		$this->bits = 0;
		$this->nbits = 0;
		$this->needed = 0;
		$this->output = null;
		$this->outpos = 0;
		$this->lengths = new \Array_hx();
		$_this = $this->lengths;
		$_this->arr[$_this->length++] = -1;
		$_this = $this->lengths;
		$_this->arr[$_this->length++] = -1;
		$_this = $this->lengths;
		$_this->arr[$_this->length++] = -1;
		$_this = $this->lengths;
		$_this->arr[$_this->length++] = -1;
		$_this = $this->lengths;
		$_this->arr[$_this->length++] = -1;
		$_this = $this->lengths;
		$_this->arr[$_this->length++] = -1;
		$_this = $this->lengths;
		$_this->arr[$_this->length++] = -1;
		$_this = $this->lengths;
		$_this->arr[$_this->length++] = -1;
		$_this = $this->lengths;
		$_this->arr[$_this->length++] = -1;
		$_this = $this->lengths;
		$_this->arr[$_this->length++] = -1;
		$_this = $this->lengths;
		$_this->arr[$_this->length++] = -1;
		$_this = $this->lengths;
		$_this->arr[$_this->length++] = -1;
		$_this = $this->lengths;
		$_this->arr[$_this->length++] = -1;
		$_this = $this->lengths;
		$_this->arr[$_this->length++] = -1;
		$_this = $this->lengths;
		$_this->arr[$_this->length++] = -1;
		$_this = $this->lengths;
		$_this->arr[$_this->length++] = -1;
		$_this = $this->lengths;
		$_this->arr[$_this->length++] = -1;
		$_this = $this->lengths;
		$_this->arr[$_this->length++] = -1;
		$_this = $this->lengths;
		$_this->arr[$_this->length++] = -1;
		$this->window = new Window($crc);
	}

	/**
	 * @param int $b
	 * 
	 * @return void
	 */
	public function addByte ($b) {
		$this->window->addByte($b);
		$this->output->b->s[$this->outpos] = \chr($b);
		$this->needed--;
		$this->outpos++;
	}

	/**
	 * @param Bytes $b
	 * @param int $p
	 * @param int $len
	 * 
	 * @return void
	 */
	public function addBytes ($b, $p, $len) {
		$this->window->addBytes($b, $p, $len);
		$_this = $this->output;
		$pos = $this->outpos;
		if (($pos < 0) || ($p < 0) || ($len < 0) || (($pos + $len) > $_this->length) || (($p + $len) > $b->length)) {
			throw Exception::thrown(Error::OutsideBounds());
		} else {
			$this1 = $_this->b;
			$src = $b->b;
			$this1->s = ((\substr($this1->s, 0, $pos) . \substr($src->s, $p, $len)) . \substr($this1->s, $pos + $len));
		}
		$this->needed -= $len;
		$this->outpos += $len;
	}

	/**
	 * @param int $d
	 * @param int $len
	 * 
	 * @return void
	 */
	public function addDist ($d, $len) {
		$this->addBytes($this->window->buffer, $this->window->pos - $d, $len);
	}

	/**
	 * @param int $n
	 * 
	 * @return void
	 */
	public function addDistOne ($n) {
		$c = $this->window->getLastChar();
		$_g = 0;
		while ($_g < $n) {
			++$_g;
			$this->addByte($c);
		}
	}

	/**
	 * @param Huffman $h
	 * 
	 * @return int
	 */
	public function applyHuffman ($h) {
		$__hx__switch = ($h->index);
		if ($__hx__switch === 0) {
			return $h->params[0];
		} else if ($__hx__switch === 1) {
			return $this->applyHuffman(($this->getBit() ? $h->params[1] : $h->params[0]));
		} else if ($__hx__switch === 2) {
			return $this->applyHuffman(($h->params[1]->arr[$this->getBits($h->params[0])] ?? null));
		}
	}

	/**
	 * @return Huffman
	 */
	public function buildFixedHuffman () {
		if (InflateImpl::$FIXED_HUFFMAN !== null) {
			return InflateImpl::$FIXED_HUFFMAN;
		}
		$a = new \Array_hx();
		$_g = 0;
		while ($_g < 288) {
			$n = $_g++;
			$a->arr[$a->length++] = ($n <= 143 ? 8 : ($n <= 255 ? 9 : ($n <= 279 ? 7 : 8)));
		}
		InflateImpl::$FIXED_HUFFMAN = $this->htools->make($a, 0, 288, 10);
		return InflateImpl::$FIXED_HUFFMAN;
	}

	/**
	 * @return bool
	 */
	public function getBit () {
		if ($this->nbits === 0) {
			$this->nbits = 8;
			$this->bits = $this->input->readByte();
		}
		$b = ($this->bits & 1) === 1;
		$this->nbits--;
		$this->bits >>= 1;
		return $b;
	}

	/**
	 * @param int $n
	 * 
	 * @return int
	 */
	public function getBits ($n) {
		while ($this->nbits < $n) {
			$tmp = $this;
			$tmp->bits = $tmp->bits | ($this->input->readByte() << $this->nbits);
			$this->nbits += 8;
		}
		$b = $this->bits & ((1 << $n) - 1);
		$this->nbits -= $n;
		$this->bits >>= $n;
		return $b;
	}

	/**
	 * @param int $n
	 * 
	 * @return int
	 */
	public function getRevBits ($n) {
		if ($n === 0) {
			return 0;
		} else if ($this->getBit()) {
			return (1 << ($n - 1)) | $this->getRevBits($n - 1);
		} else {
			return $this->getRevBits($n - 1);
		}
	}

	/**
	 * @param \Array_hx $a
	 * @param int $max
	 * 
	 * @return void
	 */
	public function inflateLengths ($a, $max) {
		$i = 0;
		$prev = 0;
		while ($i < $max) {
			$n = $this->applyHuffman($this->huffman);
			if ($n === 0 || $n === 1 || $n === 2 || $n === 3 || $n === 4 || $n === 5 || $n === 6 || $n === 7 || $n === 8 || $n === 9 || $n === 10 || $n === 11 || $n === 12 || $n === 13 || $n === 14 || $n === 15) {
				$prev = $n;
				$a->offsetSet($i, $n);
				++$i;
			} else if ($n === 16) {
				$end = $i + 3 + $this->getBits(2);
				if ($end > $max) {
					throw Exception::thrown("Invalid data");
				}
				while ($i < $end) {
					$a->offsetSet($i, $prev);
					++$i;
				}
			} else if ($n === 17) {
				$i += 3 + $this->getBits(3);
				if ($i > $max) {
					throw Exception::thrown("Invalid data");
				}
			} else if ($n === 18) {
				$i += 11 + $this->getBits(7);
				if ($i > $max) {
					throw Exception::thrown("Invalid data");
				}
			} else {
				throw Exception::thrown("Invalid data");
			}
		}
	}

	/**
	 * @return bool
	 */
	public function inflateLoop () {
		$__hx__switch = ($this->state->index);
		if ($__hx__switch === 0) {
			$cmf = $this->input->readByte();
			if (($cmf & 15) !== 8) {
				throw Exception::thrown("Invalid data");
			}
			$flg = $this->input->readByte();
			if (((($cmf << 8) + $flg) % 31) !== 0) {
				throw Exception::thrown("Invalid data");
			}
			if (($flg & 32) !== 0) {
				throw Exception::thrown("Unsupported dictionary");
			}
			$this->state = State::Block();
			return true;
		} else if ($__hx__switch === 1) {
			$this->isFinal = $this->getBit();
			$__hx__switch = ($this->getBits(2));
			if ($__hx__switch === 0) {
				$this->len = $this->input->readUInt16();
				if ($this->input->readUInt16() !== (65535 - $this->len)) {
					throw Exception::thrown("Invalid data");
				}
				$this->state = State::Flat();
				$r = $this->inflateLoop();
				$this->resetBits();
				return $r;
			} else if ($__hx__switch === 1) {
				$this->huffman = $this->buildFixedHuffman();
				$this->huffdist = null;
				$this->state = State::CData();
				return true;
			} else if ($__hx__switch === 2) {
				$hlit = $this->getBits(5) + 257;
				$hdist = $this->getBits(5) + 1;
				$hclen = $this->getBits(4) + 4;
				$_g = 0;
				while ($_g < $hclen) {
					$this->lengths->offsetSet((InflateImpl::$CODE_LENGTHS_POS->arr[$_g++] ?? null), $this->getBits(3));
				}
				$_g = $hclen;
				while ($_g < 19) {
					$this->lengths->offsetSet((InflateImpl::$CODE_LENGTHS_POS->arr[$_g++] ?? null), 0);
				}
				$this->huffman = $this->htools->make($this->lengths, 0, 19, 8);
				$lengths = new \Array_hx();
				$_g = 0;
				$_g1 = $hlit + $hdist;
				while ($_g < $_g1) {
					++$_g;
					$lengths->arr[$lengths->length++] = 0;
				}
				$this->inflateLengths($lengths, $hlit + $hdist);
				$this->huffdist = $this->htools->make($lengths, $hlit, $hdist, 16);
				$this->huffman = $this->htools->make($lengths, 0, $hlit, 16);
				$this->state = State::CData();
				return true;
			} else {
				throw Exception::thrown("Invalid data");
			}
		} else if ($__hx__switch === 2) {
			$n = $this->applyHuffman($this->huffman);
			if ($n < 256) {
				$this->addByte($n);
				return $this->needed > 0;
			} else if ($n === 256) {
				$this->state = ($this->isFinal ? State::Crc() : State::Block());
				return true;
			} else {
				$n -= 257;
				$extra_bits = (InflateImpl::$LEN_EXTRA_BITS_TBL->arr[$n] ?? null);
				if ($extra_bits === -1) {
					throw Exception::thrown("Invalid data");
				}
				$this->len = (InflateImpl::$LEN_BASE_VAL_TBL->arr[$n] ?? null) + $this->getBits($extra_bits);
				$dist_code = ($this->huffdist === null ? $this->getRevBits(5) : $this->applyHuffman($this->huffdist));
				$extra_bits = (InflateImpl::$DIST_EXTRA_BITS_TBL->arr[$dist_code] ?? null);
				if ($extra_bits === -1) {
					throw Exception::thrown("Invalid data");
				}
				$this->dist = (InflateImpl::$DIST_BASE_VAL_TBL->arr[$dist_code] ?? null) + $this->getBits($extra_bits);
				if ($this->dist > $this->window->available()) {
					throw Exception::thrown("Invalid data");
				}
				$this->state = ($this->dist === 1 ? State::DistOne() : State::Dist());
				return true;
			}
		} else if ($__hx__switch === 3) {
			$rlen = ($this->len < $this->needed ? $this->len : $this->needed);
			$bytes = $this->input->read($rlen);
			$this->len -= $rlen;
			$this->addBytes($bytes, 0, $rlen);
			if ($this->len === 0) {
				$this->state = ($this->isFinal ? State::Crc() : State::Block());
			}
			return $this->needed > 0;
		} else if ($__hx__switch === 4) {
			$calc = $this->window->checksum();
			if ($calc === null) {
				$this->state = State::Done();
				return true;
			}
			if (!$calc->equals(Adler32::read($this->input))) {
				throw Exception::thrown("Invalid CRC");
			}
			$this->state = State::Done();
			return true;
		} else if ($__hx__switch === 5) {
			while (($this->len > 0) && ($this->needed > 0)) {
				$rdist = ($this->len < $this->dist ? $this->len : $this->dist);
				$rlen = ($this->needed < $rdist ? $this->needed : $rdist);
				$this->addDist($this->dist, $rlen);
				$this->len -= $rlen;
			}
			if ($this->len === 0) {
				$this->state = State::CData();
			}
			return $this->needed > 0;
		} else if ($__hx__switch === 6) {
			$rlen = ($this->len < $this->needed ? $this->len : $this->needed);
			$this->addDistOne($rlen);
			$this->len -= $rlen;
			if ($this->len === 0) {
				$this->state = State::CData();
			}
			return $this->needed > 0;
		} else if ($__hx__switch === 7) {
			return false;
		}
	}

	/**
	 * @param Bytes $b
	 * @param int $pos
	 * @param int $len
	 * 
	 * @return int
	 */
	public function readBytes ($b, $pos, $len) {
		$this->needed = $len;
		$this->outpos = $pos;
		$this->output = $b;
		if ($len > 0) {
			while ($this->inflateLoop()) {
			}
		}
		return $len - $this->needed;
	}

	/**
	 * @return void
	 */
	public function resetBits () {
		$this->bits = 0;
		$this->nbits = 0;
	}

	/**
	 * @internal
	 * @access private
	 */
	static public function __hx__init ()
	{
		static $called = false;
		if ($called) return;
		$called = true;


		self::$LEN_EXTRA_BITS_TBL = \Array_hx::wrap([
			0,
			0,
			0,
			0,
			0,
			0,
			0,
			0,
			1,
			1,
			1,
			1,
			2,
			2,
			2,
			2,
			3,
			3,
			3,
			3,
			4,
			4,
			4,
			4,
			5,
			5,
			5,
			5,
			0,
			-1,
			-1,
		]);
		self::$LEN_BASE_VAL_TBL = \Array_hx::wrap([
			3,
			4,
			5,
			6,
			7,
			8,
			9,
			10,
			11,
			13,
			15,
			17,
			19,
			23,
			27,
			31,
			35,
			43,
			51,
			59,
			67,
			83,
			99,
			115,
			131,
			163,
			195,
			227,
			258,
		]);
		self::$DIST_EXTRA_BITS_TBL = \Array_hx::wrap([
			0,
			0,
			0,
			0,
			1,
			1,
			2,
			2,
			3,
			3,
			4,
			4,
			5,
			5,
			6,
			6,
			7,
			7,
			8,
			8,
			9,
			9,
			10,
			10,
			11,
			11,
			12,
			12,
			13,
			13,
			-1,
			-1,
		]);
		self::$DIST_BASE_VAL_TBL = \Array_hx::wrap([
			1,
			2,
			3,
			4,
			5,
			7,
			9,
			13,
			17,
			25,
			33,
			49,
			65,
			97,
			129,
			193,
			257,
			385,
			513,
			769,
			1025,
			1537,
			2049,
			3073,
			4097,
			6145,
			8193,
			12289,
			16385,
			24577,
		]);
		self::$CODE_LENGTHS_POS = \Array_hx::wrap([
			16,
			17,
			18,
			0,
			8,
			7,
			9,
			6,
			10,
			5,
			11,
			4,
			12,
			3,
			13,
			2,
			14,
			1,
			15,
		]);
	}
}

Boot::registerClass(InflateImpl::class, 'haxe.zip.InflateImpl');
InflateImpl::__hx__init();
