<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace haxe\crypto;

use \php\Boot;
use \haxe\io\Bytes;

/**
 * Calculates the Crc32 of the given Bytes.
 */
class Crc32 {
	/**
	 * @var int
	 */
	public $crc;

	/**
	 * Calculates the CRC32 of the given data bytes
	 * 
	 * @param Bytes $data
	 * 
	 * @return int
	 */
	public static function make ($data) {
		$c_crc = -1;
		$len = $data->length;
		$b = $data->b;
		$_g = 0;
		while ($_g < $len) {
			$tmp = ($c_crc ^ \ord($b->s[$_g++])) & 255;
			$tmp = Boot::shiftRightUnsigned($tmp, 1) ^ (-($tmp & 1) & -306674912);
			$tmp = Boot::shiftRightUnsigned($tmp, 1) ^ (-($tmp & 1) & -306674912);
			$tmp = Boot::shiftRightUnsigned($tmp, 1) ^ (-($tmp & 1) & -306674912);
			$tmp = Boot::shiftRightUnsigned($tmp, 1) ^ (-($tmp & 1) & -306674912);
			$tmp = Boot::shiftRightUnsigned($tmp, 1) ^ (-($tmp & 1) & -306674912);
			$tmp = Boot::shiftRightUnsigned($tmp, 1) ^ (-($tmp & 1) & -306674912);
			$tmp = Boot::shiftRightUnsigned($tmp, 1) ^ (-($tmp & 1) & -306674912);
			$tmp = Boot::shiftRightUnsigned($tmp, 1) ^ (-($tmp & 1) & -306674912);
			$c_crc = Boot::shiftRightUnsigned($c_crc, 8) ^ $tmp;
		}
		return $c_crc ^ -1;
	}

	/**
	 * @return void
	 */
	public function __construct () {
		$this->crc = -1;
	}

	/**
	 * @param int $b
	 * 
	 * @return void
	 */
	public function byte ($b) {
		$tmp = ($this->crc ^ $b) & 255;
		$tmp = Boot::shiftRightUnsigned($tmp, 1) ^ (-($tmp & 1) & -306674912);
		$tmp = Boot::shiftRightUnsigned($tmp, 1) ^ (-($tmp & 1) & -306674912);
		$tmp = Boot::shiftRightUnsigned($tmp, 1) ^ (-($tmp & 1) & -306674912);
		$tmp = Boot::shiftRightUnsigned($tmp, 1) ^ (-($tmp & 1) & -306674912);
		$tmp = Boot::shiftRightUnsigned($tmp, 1) ^ (-($tmp & 1) & -306674912);
		$tmp = Boot::shiftRightUnsigned($tmp, 1) ^ (-($tmp & 1) & -306674912);
		$tmp = Boot::shiftRightUnsigned($tmp, 1) ^ (-($tmp & 1) & -306674912);
		$tmp = Boot::shiftRightUnsigned($tmp, 1) ^ (-($tmp & 1) & -306674912);
		$this->crc = Boot::shiftRightUnsigned($this->crc, 8) ^ $tmp;
	}

	/**
	 * @return int
	 */
	public function get () {
		return $this->crc ^ -1;
	}

	/**
	 * @param Bytes $b
	 * @param int $pos
	 * @param int $len
	 * 
	 * @return void
	 */
	public function update ($b, $pos, $len) {
		$b1 = $b->b;
		$_g = $pos;
		$_g1 = $pos + $len;
		while ($_g < $_g1) {
			$tmp = ($this->crc ^ \ord($b1->s[$_g++])) & 255;
			$tmp = Boot::shiftRightUnsigned($tmp, 1) ^ (-($tmp & 1) & -306674912);
			$tmp = Boot::shiftRightUnsigned($tmp, 1) ^ (-($tmp & 1) & -306674912);
			$tmp = Boot::shiftRightUnsigned($tmp, 1) ^ (-($tmp & 1) & -306674912);
			$tmp = Boot::shiftRightUnsigned($tmp, 1) ^ (-($tmp & 1) & -306674912);
			$tmp = Boot::shiftRightUnsigned($tmp, 1) ^ (-($tmp & 1) & -306674912);
			$tmp = Boot::shiftRightUnsigned($tmp, 1) ^ (-($tmp & 1) & -306674912);
			$tmp = Boot::shiftRightUnsigned($tmp, 1) ^ (-($tmp & 1) & -306674912);
			$tmp = Boot::shiftRightUnsigned($tmp, 1) ^ (-($tmp & 1) & -306674912);
			$this->crc = Boot::shiftRightUnsigned($this->crc, 8) ^ $tmp;
		}
	}
}

Boot::registerClass(Crc32::class, 'haxe.crypto.Crc32');
