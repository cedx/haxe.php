<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace tink\chunk;

use \php\Boot;
use \haxe\io\Bytes;

interface ChunkObject {
	/**
	 * @param Bytes $target
	 * @param int $offset
	 * 
	 * @return void
	 */
	public function blitTo ($target, $offset) ;

	/**
	 * @param \Array_hx $into
	 * 
	 * @return void
	 */
	public function flatten ($into) ;

	/**
	 * @param int $i
	 * 
	 * @return int
	 */
	public function getByte ($i) ;

	/**
	 * @return ChunkCursor
	 */
	public function getCursor () ;

	/**
	 * @return int
	 */
	public function getLength () ;

	/**
	 * @param int $from
	 * @param int $to
	 * 
	 * @return ChunkObject
	 */
	public function slice ($from, $to) ;

	/**
	 * @return Bytes
	 */
	public function toBytes () ;

	/**
	 * @return string
	 */
	public function toString () ;
}

Boot::registerClass(ChunkObject::class, 'tink.chunk.ChunkObject');
