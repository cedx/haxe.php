<?php
/**
 * Generated by Haxe 4.1.1
 */

namespace haxe\http;

use \php\_Boot\HxAnon;
use \php\Boot;
use \haxe\Exception;
use \haxe\io\Error;
use \php\_Boot\HxClosure;
use \haxe\io\Bytes;

/**
 * This class can be used to handle Http requests consistently across
 * platforms. There are two intended usages:
 * - call `haxe.Http.requestUrl(url)` and receive the result as a `String`
 * (not available on flash)
 * - create a `new haxe.Http(url)`, register your callbacks for `onData`,
 * `onError` and `onStatus`, then call `request()`.
 */
class HttpBase {
	/**
	 * @var \Closure
	 */
	public $emptyOnData;
	/**
	 * @var \Array_hx
	 */
	public $headers;
	/**
	 * @var \Closure
	 * This method is called upon a successful request, with `data` containing
	 * the result String.
	 * The intended usage is to bind it to a custom function:
	 * `httpInstance.onBytes = function(data) { // handle result }`
	 */
	public $onBytes;
	/**
	 * @var \Closure
	 * This method is called upon a successful request, with `data` containing
	 * the result String.
	 * The intended usage is to bind it to a custom function:
	 * `httpInstance.onData = function(data) { // handle result }`
	 */
	public $onData;
	/**
	 * @var \Closure
	 * This method is called upon a request error, with `msg` containing the
	 * error description.
	 * The intended usage is to bind it to a custom function:
	 * `httpInstance.onError = function(msg) { // handle error }`
	 */
	public $onError;
	/**
	 * @var \Closure
	 * This method is called upon a Http status change, with `status` being the
	 * new status.
	 * The intended usage is to bind it to a custom function:
	 * `httpInstance.onStatus = function(status) { // handle status }`
	 */
	public $onStatus;
	/**
	 * @var \Array_hx
	 */
	public $params;
	/**
	 * @var Bytes
	 */
	public $postBytes;
	/**
	 * @var string
	 */
	public $postData;
	/**
	 * @var string
	 */
	public $responseAsString;
	/**
	 * @var Bytes
	 */
	public $responseBytes;
	/**
	 * @var string
	 * The url of `this` request. It is used only by the `request()` method and
	 * can be changed in order to send the same request to different target
	 * Urls.
	 */
	public $url;

	/**
	 * Creates a new Http instance with `url` as parameter.
	 * This does not do a request until `request()` is called.
	 * If `url` is null, the field url must be set to a value before making the
	 * call to `request()`, or the result is unspecified.
	 * (Php) Https (SSL) connections are allowed only if the OpenSSL extension
	 * is enabled.
	 * 
	 * @param string $url
	 * 
	 * @return void
	 */
	public function __construct ($url) {
		if (!$this->__hx__default__onData) {
			$this->__hx__default__onData = new HxClosure($this, 'onData');
			if ($this->onData === null) $this->onData = $this->__hx__default__onData;
		}
		if (!$this->__hx__default__onBytes) {
			$this->__hx__default__onBytes = new HxClosure($this, 'onBytes');
			if ($this->onBytes === null) $this->onBytes = $this->__hx__default__onBytes;
		}
		if (!$this->__hx__default__onError) {
			$this->__hx__default__onError = new HxClosure($this, 'onError');
			if ($this->onError === null) $this->onError = $this->__hx__default__onError;
		}
		if (!$this->__hx__default__onStatus) {
			$this->__hx__default__onStatus = new HxClosure($this, 'onStatus');
			if ($this->onStatus === null) $this->onStatus = $this->__hx__default__onStatus;
		}
		$this->url = $url;
		$this->headers = new \Array_hx();
		$this->params = new \Array_hx();
		$this->emptyOnData = $this->onData;
	}

	/**
	 * @param string $header
	 * @param string $value
	 * 
	 * @return void
	 */
	public function addHeader ($header, $value) {
		$_this = $this->headers;
		$_this->arr[$_this->length++] = new HxAnon([
			"name" => $header,
			"value" => $value,
		]);
	}

	/**
	 * @param string $name
	 * @param string $value
	 * 
	 * @return void
	 */
	public function addParameter ($name, $value) {
		$_this = $this->params;
		$_this->arr[$_this->length++] = new HxAnon([
			"name" => $name,
			"value" => $value,
		]);
	}

	/**
	 * @return string
	 */
	public function get_responseData () {
		if (($this->responseAsString === null) && ($this->responseBytes !== null)) {
			$_this = $this->responseBytes;
			$len = $this->responseBytes->length;
			$tmp = null;
			if (($len < 0) || ($len > $_this->length)) {
				throw Exception::thrown(Error::OutsideBounds());
			} else {
				$tmp = substr($_this->b->s, 0, $len);
			}
			$this->responseAsString = $tmp;
		}
		return $this->responseAsString;
	}

	/**
	 * Override this if extending `haxe.Http` with overriding `onData`
	 * 
	 * @return bool
	 */
	public function hasOnData () {
		return !\Reflect::compareMethods($this->onData, $this->emptyOnData);
	}

	/**
	 * This method is called upon a successful request, with `data` containing
	 * the result String.
	 * The intended usage is to bind it to a custom function:
	 * `httpInstance.onBytes = function(data) { // handle result }`
	 * 
	 * @param Bytes $data
	 * 
	 * @return void
	 */
	public function onBytes ($data)
	{
		if ($this->onBytes !== $this->__hx__default__onBytes) return call_user_func_array($this->onBytes, func_get_args());
	}
	protected $__hx__default__onBytes;

	/**
	 * This method is called upon a successful request, with `data` containing
	 * the result String.
	 * The intended usage is to bind it to a custom function:
	 * `httpInstance.onData = function(data) { // handle result }`
	 * 
	 * @param string $data
	 * 
	 * @return void
	 */
	public function onData ($data)
	{
		if ($this->onData !== $this->__hx__default__onData) return call_user_func_array($this->onData, func_get_args());
	}
	protected $__hx__default__onData;

	/**
	 * This method is called upon a request error, with `msg` containing the
	 * error description.
	 * The intended usage is to bind it to a custom function:
	 * `httpInstance.onError = function(msg) { // handle error }`
	 * 
	 * @param string $msg
	 * 
	 * @return void
	 */
	public function onError ($msg)
	{
		if ($this->onError !== $this->__hx__default__onError) return call_user_func_array($this->onError, func_get_args());
	}
	protected $__hx__default__onError;

	/**
	 * This method is called upon a Http status change, with `status` being the
	 * new status.
	 * The intended usage is to bind it to a custom function:
	 * `httpInstance.onStatus = function(status) { // handle status }`
	 * 
	 * @param int $status
	 * 
	 * @return void
	 */
	public function onStatus ($status)
	{
		if ($this->onStatus !== $this->__hx__default__onStatus) return call_user_func_array($this->onStatus, func_get_args());
	}
	protected $__hx__default__onStatus;

	/**
	 * Sends `this` Http request to the Url specified by `this.url`.
	 * If `post` is true, the request is sent as POST request, otherwise it is
	 * sent as GET request.
	 * Depending on the outcome of the request, this method calls the
	 * `onStatus()`, `onError()`, `onData()` or `onBytes()` callback functions.
	 * If `this.url` is null, the result is unspecified.
	 * If `this.url` is an invalid or inaccessible Url, the `onError()` callback
	 * function is called.
	 * [js] If `this.async` is false, the callback functions are called before
	 * this method returns.
	 * 
	 * @param bool $post
	 * 
	 * @return void
	 */
	public function request ($post = null) {
		throw Exception::thrown("not implemented");
	}

	/**
	 * Sets the header identified as `header` to value `value`.
	 * If `header` or `value` are null, the result is unspecified.
	 * This method provides a fluent interface.
	 * 
	 * @param string $name
	 * @param string $value
	 * 
	 * @return void
	 */
	public function setHeader ($name, $value) {
		$_g = 0;
		$_g1 = $this->headers->length;
		while ($_g < $_g1) {
			$i = $_g++;
			if (($this->headers->arr[$i] ?? null)->name === $name) {
				$this->headers->offsetSet($i, new HxAnon([
					"name" => $name,
					"value" => $value,
				]));
				return;
			}
		}
		$_this = $this->headers;
		$_this->arr[$_this->length++] = new HxAnon([
			"name" => $name,
			"value" => $value,
		]);
	}

	/**
	 * Sets the parameter identified as `param` to value `value`.
	 * If `header` or `value` are null, the result is unspecified.
	 * This method provides a fluent interface.
	 * 
	 * @param string $name
	 * @param string $value
	 * 
	 * @return void
	 */
	public function setParameter ($name, $value) {
		$_g = 0;
		$_g1 = $this->params->length;
		while ($_g < $_g1) {
			$i = $_g++;
			if (($this->params->arr[$i] ?? null)->name === $name) {
				$this->params->offsetSet($i, new HxAnon([
					"name" => $name,
					"value" => $value,
				]));
				return;
			}
		}
		$_this = $this->params;
		$_this->arr[$_this->length++] = new HxAnon([
			"name" => $name,
			"value" => $value,
		]);
	}

	/**
	 * Sets the post data of `this` Http request to `data` bytes.
	 * There can only be one post data per request. Subsequent calls to
	 * this method or to `setPostData()` overwrite the previously set value.
	 * If `data` is null, the post data is considered to be absent.
	 * This method provides a fluent interface.
	 * 
	 * @param Bytes $data
	 * 
	 * @return void
	 */
	public function setPostBytes ($data) {
		$this->postBytes = $data;
		$this->postData = null;
	}

	/**
	 * Sets the post data of `this` Http request to `data` string.
	 * There can only be one post data per request. Subsequent calls to
	 * this method or to `setPostBytes()` overwrite the previously set value.
	 * If `data` is null, the post data is considered to be absent.
	 * This method provides a fluent interface.
	 * 
	 * @param string $data
	 * 
	 * @return void
	 */
	public function setPostData ($data) {
		$this->postData = $data;
		$this->postBytes = null;
	}

	/**
	 * @param Bytes $data
	 * 
	 * @return void
	 */
	public function success ($data) {
		$this->responseBytes = $data;
		$this->responseAsString = null;
		if ($this->hasOnData()) {
			$this->onData($this->get_responseData());
		}
		$this->onBytes($this->responseBytes);
	}
}

Boot::registerClass(HttpBase::class, 'haxe.http.HttpBase');
Boot::registerGetters('haxe\\http\\HttpBase', [
	'responseData' => true
]);