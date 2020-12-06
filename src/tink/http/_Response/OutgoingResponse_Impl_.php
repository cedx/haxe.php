<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace tink\http\_Response;

use \tink\chunk\ChunkObject;
use \php\_Boot\HxAnon;
use \haxe\io\_BytesData\Container;
use \tink\http\HeaderField;
use \php\Boot;
use \tink\streams\Single;
use \tink\core\TypedError;
use \tink\streams\StreamObject;
use \tink\chunk\ByteChunk;
use \tink\http\ResponseHeaderBase;
use \tink\core\_Lazy\LazyConst;
use \haxe\Json;
use \httpstatus\_HttpStatusMessage\HttpStatusMessage_Impl_;
use \haxe\io\Bytes;

final class OutgoingResponse_Impl_ {
	/**
	 * @param ResponseHeaderBase $header
	 * @param StreamObject $body
	 * 
	 * @return OutgoingResponseData
	 */
	public static function _new ($header, $body) {
		return new OutgoingResponseData($header, $body);
	}

	/**
	 * @param int $code
	 * @param ChunkObject $chunk
	 * @param string $contentType
	 * @param \Array_hx $headers
	 * 
	 * @return OutgoingResponseData
	 */
	public static function blob ($code = 200, $chunk, $contentType, $headers = null) {
		if ($code === null) {
			$code = 200;
		}
		$this1 = HttpStatusMessage_Impl_::fromCode($code);
		$fields = new HeaderField(\mb_strtolower("Content-Type"), $contentType);
		$fields1 = \mb_strtolower("Content-Length");
		$this2 = new ResponseHeaderBase($code, $this1, (\Array_hx::wrap([
			$fields,
			new HeaderField($fields1, \Std::string($chunk->getLength())),
		]))->concat(($headers === null ? new \Array_hx() : $headers)), "HTTP/1.1");
		return new OutgoingResponseData($this2, new Single(new LazyConst($chunk)));
	}

	/**
	 * @param string $contentType
	 * @param mixed $headers
	 * @param StreamObject $source
	 * 
	 * @return void
	 */
	public static function chunked ($contentType, $headers = null, $source) {
	}

	/**
	 * @param ChunkObject $c
	 * 
	 * @return OutgoingResponseData
	 */
	public static function ofChunk ($c) {
		return OutgoingResponse_Impl_::blob(null, $c, "application/octet-stream");
	}

	/**
	 * @param string $s
	 * 
	 * @return OutgoingResponseData
	 */
	public static function ofString ($s) {
		$b = \strlen($s);
		return OutgoingResponse_Impl_::blob(null, ByteChunk::of(new Bytes($b, new Container($s))), "text/plain");
	}

	/**
	 * @param TypedError $e
	 * 
	 * @return OutgoingResponseData
	 */
	public static function reportError ($e) {
		$code = $e->code;
		if (($code < 100) || ($code > 999)) {
			$code = 500;
		}
		$reason = HttpStatusMessage_Impl_::fromCode($code);
		$this1 = new ResponseHeaderBase($code, $reason, \Array_hx::wrap([new HeaderField(\mb_strtolower("Content-Type"), "application/json")]), "HTTP/1.1");
		$s = Json::phpJsonEncode(new HxAnon([
			"error" => $e->message,
			"details" => $e->data,
		]), null, null);
		$b = \strlen($s);
		return new OutgoingResponseData($this1, new Single(new LazyConst(ByteChunk::of(new Bytes($b, new Container($s))))));
	}
}

Boot::registerClass(OutgoingResponse_Impl_::class, 'tink.http._Response.OutgoingResponse_Impl_');
