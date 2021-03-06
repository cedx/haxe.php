<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace tink\http;

use \php\Boot;
use \tink\io\Transformer;
use \tink\streams\_Stream\Stream_Impl_;
use \haxe\io\_BytesData\Container as _BytesDataContainer;
use \tink\io\_Source\Source_Impl_;
use \tink\streams\StreamObject;
use \tink\chunk\ByteChunk;
use \tink\streams\_Stream\Mapping_Impl_;
use \haxe\io\Bytes;
use \tink\_Chunk\Chunk_Impl_;
use \haxe\iterators\ArrayIterator;

class ChunkedEncoder implements Transformer {
	/**
	 * @return void
	 */
	public function __construct () {
	}

	/**
	 * @param StreamObject $source
	 * 
	 * @return StreamObject
	 */
	public function transform ($source) {
		$tmp = Source_Impl_::chunked($source)->map(Mapping_Impl_::ofPlain(function ($chunk) {
			$s = "" . (\StringTools::hex($chunk->getLength())??'null') . "\x0D\x0A";
			$b = \strlen($s);
			$tmp = Chunk_Impl_::catChunk(ByteChunk::of(new Bytes($b, new _BytesDataContainer($s))), $chunk);
			$b = \strlen("\x0D\x0A");
			return Chunk_Impl_::catChunk($tmp, ByteChunk::of(new Bytes($b, new _BytesDataContainer("\x0D\x0A"))));
		}));
		$b = \strlen("0\x0D\x0A");
		return $tmp->append(Stream_Impl_::ofIterator(new ArrayIterator(\Array_hx::wrap([ByteChunk::of(new Bytes($b, new _BytesDataContainer("0\x0D\x0A")))]))));
	}
}

Boot::registerClass(ChunkedEncoder::class, 'tink.http.ChunkedEncoder');
