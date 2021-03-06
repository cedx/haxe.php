<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace tink\http\clients;

use \php\_Boot\HxAnon;
use \tink\core\_Future\SyncFuture;
use \tink\io\RealSourceTools;
use \php\Boot;
use \tink\io\std\InputSource;
use \tink\http\IncomingResponse;
use \tink\io\_Source\Source_Impl_;
use \sys\io\Process;
use \tink\streams\StreamObject;
use \tink\io\_Worker\Worker_Impl_;
use \tink\core\Outcome;
use \tink\http\ResponseHeaderBase;
use \tink\core\_Lazy\LazyConst;
use \php\_Boot\HxClosure;
use \tink\_Url\Url_Impl_;
use \tink\http\ClientObject;
use \tink\core\_Promise\Promise_Impl_;
use \tink\io\_Sink\SinkYielding_Impl_;
use \haxe\io\Bytes;
use \tink\http\OutgoingRequest;
use \tink\core\FutureObject;

class CurlClient implements ClientObject {
	/**
	 * @var \Closure
	 */
	public $curl;
	/**
	 * @var string
	 */
	public $protocol;

	/**
	 * @param \Closure $curl
	 * 
	 * @return void
	 */
	public function __construct ($curl = null) {
		if (!$this->__hx__default__curl) {
			$this->__hx__default__curl = new HxClosure($this, 'curl');
			if ($this->curl === null) $this->curl = $this->__hx__default__curl;
		}
		$this->protocol = "http";
		if ($curl !== null) {
			$this->curl = $curl;
		}
	}

	/**
	 * @param \Array_hx $args
	 * @param StreamObject $body
	 * 
	 * @return StreamObject
	 */
	public function curl ($args, $body)
	{
		if ($this->curl !== $this->__hx__default__curl) return call_user_func_array($this->curl, func_get_args());
		$args->arr[$args->length++] = "--data-binary";
		$args->arr[$args->length++] = "@-";
		$process = new Process("curl", $args);
		Source_Impl_::pipeTo($body, SinkYielding_Impl_::ofOutput("stdin", $process->stdin), new HxAnon(["end" => true]))->eager();
		$input = $process->stdout;
		$options = null;
		$options = new HxAnon();
		$tmp = Worker_Impl_::ensure($options->worker);
		$_g = $options->chunkSize;
		return new InputSource("stdout", $input, $tmp, Bytes::alloc(($_g === null ? 65536 : $_g)), 0);
	}
	protected $__hx__default__curl;

	/**
	 * @param OutgoingRequest $req
	 * 
	 * @return FutureObject
	 */
	public function request ($req) {
		$args = new \Array_hx();
		$args->arr[$args->length++] = "-is";
		$args->arr[$args->length++] = "-X";
		$args->arr[$args->length++] = $req->header->method;
		$__hx__switch = ($req->header->protocol);
		if ($__hx__switch === "HTTP/1.0") {
			$args->arr[$args->length++] = "--http1.0";
		} else if ($__hx__switch === "HTTP/1.1") {
			$args->arr[$args->length++] = "--http1.1";
		} else if ($__hx__switch === "HTTP/2") {
			$args->arr[$args->length++] = "--http2";
		} else {
		}
		$_this = $req->header->fields;
		$_g1_current = 0;
		while ($_g1_current < $_this->length) {
			$header = ($_this->arr[$_g1_current++] ?? null);
			$args->arr[$args->length++] = "-H";
			$args->arr[$args->length++] = "" . ($header->name??'null') . ": " . ($header->value??'null');
		}
		$x = Url_Impl_::toString($req->header->url);
		$args->arr[$args->length++] = $x;
		return Promise_Impl_::next(RealSourceTools::parse($this->curl($args, $req->body), ResponseHeaderBase::parser()), function ($p) {
			return new SyncFuture(new LazyConst(Outcome::Success(new IncomingResponse($p->a, $p->b))));
		});
	}
}

Boot::registerClass(CurlClient::class, 'tink.http.clients.CurlClient');
