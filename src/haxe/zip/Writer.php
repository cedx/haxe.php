<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace haxe\zip;

use \php\_Boot\HxAnon;
use \haxe\io\_BytesData\Container;
use \php\Boot;
use \haxe\io\BytesOutput;
use \haxe\Exception;
use \haxe\io\Output;
use \haxe\crypto\Crc32;
use \haxe\ds\List_hx;
use \haxe\io\Bytes;

class Writer {
	/**
	 * @var int
	 * The next constant is required for computing the Central
	 * Directory Record(CDR) size. CDR consists of some fields
	 * of constant size and a filename. Constant represents
	 * total length of all fields with constant size for each
	 * file in archive
	 */
	const CENTRAL_DIRECTORY_RECORD_FIELDS_SIZE = 46;
	/**
	 * @var int
	 * The following constant is the total size of all fields
	 * of Local File Header. It's required for calculating
	 * offset of start of central directory record
	 */
	const LOCAL_FILE_HEADER_FIELDS_SIZE = 30;

	/**
	 * @var List_hx
	 */
	public $files;
	/**
	 * @var Output
	 */
	public $o;

	/**
	 * @param Output $o
	 * 
	 * @return void
	 */
	public function __construct ($o) {
		$this->o = $o;
		$this->files = new List_hx();
	}

	/**
	 * @param List_hx $files
	 * 
	 * @return void
	 */
	public function write ($files) {
		$_g_head = $files->h;
		while ($_g_head !== null) {
			$val = $_g_head->item;
			$_g_head = $_g_head->next;
			$this->writeEntryHeader($val);
			$this->o->writeFullBytes($val->data, 0, $val->data->length);
		}
		$this->writeCDR();
	}

	/**
	 * @return void
	 */
	public function writeCDR () {
		$cdr_size = 0;
		$cdr_offset = 0;
		$_g_head = $this->files->h;
		while ($_g_head !== null) {
			$val = $_g_head->item;
			$_g_head = $_g_head->next;
			$namelen = mb_strlen($val->name);
			$extraFieldsLength = $val->fields->length;
			$this->o->writeInt32(33639248);
			$this->o->writeUInt16(20);
			$this->o->writeUInt16(20);
			$this->o->writeUInt16(0);
			$this->o->writeUInt16(($val->compressed ? 8 : 0));
			$this->writeZipDate($val->date);
			$this->o->writeInt32($val->crc);
			$this->o->writeInt32($val->clen);
			$this->o->writeInt32($val->size);
			$this->o->writeUInt16($namelen);
			$this->o->writeUInt16($extraFieldsLength);
			$this->o->writeUInt16(0);
			$this->o->writeUInt16(0);
			$this->o->writeUInt16(0);
			$this->o->writeInt32(0);
			$this->o->writeInt32($cdr_offset);
			$this->o->writeString($val->name);
			$this->o->write($val->fields);
			$cdr_size += 46 + $namelen + $extraFieldsLength;
			$cdr_offset += 30 + $namelen + $extraFieldsLength + $val->clen;
		}
		$this->o->writeInt32(101010256);
		$this->o->writeUInt16(0);
		$this->o->writeUInt16(0);
		$this->o->writeUInt16($this->files->length);
		$this->o->writeUInt16($this->files->length);
		$this->o->writeInt32($cdr_size);
		$this->o->writeInt32($cdr_offset);
		$this->o->writeUInt16(0);
	}

	/**
	 * @param object $f
	 * 
	 * @return void
	 */
	public function writeEntryHeader ($f) {
		$o = $this->o;
		$flags = 0;
		if ($f->extraFields !== null) {
			$_g_head = $f->extraFields->h;
			while ($_g_head !== null) {
				$val = $_g_head->item;
				$_g_head = $_g_head->next;
				if ($val->index === 2) {
					$flags |= 2048;
				}
			}
		}
		$o->writeInt32(67324752);
		$o->writeUInt16(20);
		$o->writeUInt16($flags);
		if ($f->data === null) {
			$f->fileSize = 0;
			$f->dataSize = 0;
			$f->crc32 = 0;
			$f->compressed = false;
			$f->data = Bytes::alloc(0);
		} else {
			if ($f->crc32 === null) {
				if ($f->compressed) {
					throw Exception::thrown("CRC32 must be processed before compression");
				}
				$f->crc32 = Crc32::make($f->data);
			}
			if (!$f->compressed) {
				$f->fileSize = $f->data->length;
			}
			$f->dataSize = $f->data->length;
		}
		$o->writeUInt16(($f->compressed ? 8 : 0));
		$this->writeZipDate($f->fileTime);
		$o->writeInt32($f->crc32);
		$o->writeInt32($f->dataSize);
		$o->writeInt32($f->fileSize);
		$o->writeUInt16(mb_strlen($f->fileName));
		$e = new BytesOutput();
		if ($f->extraFields !== null) {
			$_g_head = $f->extraFields->h;
			while ($_g_head !== null) {
				$val = $_g_head->item;
				$_g_head = $_g_head->next;
				$__hx__switch = ($val->index);
				if ($__hx__switch === 0) {
					$_g = $val->params[1];
					$e->writeUInt16($val->params[0]);
					$e->writeUInt16($_g->length);
					$e->write($_g);
				} else if ($__hx__switch === 1) {
					$_g1 = $val->params[0];
					$namebytes = \strlen($_g1);
					$namebytes1 = new Bytes($namebytes, new Container($_g1));
					$e->writeUInt16(28789);
					$e->writeUInt16($namebytes1->length + 5);
					$e->writeByte(1);
					$e->writeInt32($val->params[1]);
					$e->write($namebytes1);
				} else if ($__hx__switch === 2) {
				}
			}
		}
		$ebytes = $e->getBytes();
		$o->writeUInt16($ebytes->length);
		$o->writeString($f->fileName);
		$o->write($ebytes);
		$this->files->add(new HxAnon([
			"name" => $f->fileName,
			"compressed" => $f->compressed,
			"clen" => $f->data->length,
			"size" => $f->fileSize,
			"crc" => $f->crc32,
			"date" => $f->fileTime,
			"fields" => $ebytes,
		]));
	}

	/**
	 * @param \Date $date
	 * 
	 * @return void
	 */
	public function writeZipDate ($date) {
		$hour = $date->getHours();
		$min = $date->getMinutes();
		$sec = $date->getSeconds() >> 1;
		$this->o->writeUInt16(($hour << 11) | ($min << 5) | $sec);
		$year = $date->getFullYear() - 1980;
		$month = $date->getMonth() + 1;
		$day = $date->getDate();
		$this->o->writeUInt16(($year << 9) | ($month << 5) | $day);
	}
}

Boot::registerClass(Writer::class, 'haxe.zip.Writer');
