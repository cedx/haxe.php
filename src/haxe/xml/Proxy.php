<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace haxe\xml;

use \php\Boot;

/**
 * This proxy can be inherited with an XML file name parameter.
 * It will	only allow access to fields which corresponds to an "id" attribute
 * value in the XML file :
 * ```haxe
 * class MyXml extends haxe.xml.Proxy<"my.xml", MyStructure> {
 * }
 * var h = new haxe.ds.StringMap<MyStructure>();
 * // ... fill h with "my.xml" content
 * var m = new MyXml(h.get);
 * trace(m.myNode.structField);
 * // Access to "myNode" is only possible if you have an id="myNode" attribute
 * // in your XML, and completion works as well.
 * ```
 */
class Proxy {
	/**
	 * @var \Closure
	 */
	public $__f;

	/**
	 * @param \Closure $f
	 * 
	 * @return void
	 */
	public function __construct ($f) {
		$this->__f = $f;
	}

	/**
	 * @param string $k
	 * 
	 * @return mixed
	 */
	public function resolve ($k) {
		return ($this->__f)($k);
	}
}

Boot::registerClass(Proxy::class, 'haxe.xml.Proxy');
