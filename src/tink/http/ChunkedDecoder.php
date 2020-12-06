<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace tink\http;

use \tink\io\RealSourceTools;
use \php\Boot;
use \tink\io\Transformer;
use \tink\streams\StreamObject;
use \tink\streams\_Stream\Mapping_Impl_;
use \tink\_Chunk\Chunk_Impl_;

class ChunkedDecoder implements Transformer {
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
		return RealSourceTools::parseStream($source, new ChunkedParser())->map(Mapping_Impl_::ofPlain(function ($v) {
			if ($v === null) {
				return Chunk_Impl_::$EMPTY;
			} else {
				return $v;
			}
		}));
	}
}

Boot::registerClass(ChunkedDecoder::class, 'tink.http.ChunkedDecoder');
