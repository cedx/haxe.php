<?php
/**
 * Generated by Haxe 4.1.2
 */

namespace haxe;

use \haxe\_EntryPoint\Lock;
use \php\Boot;
use \haxe\_EntryPoint\Mutex;
use \haxe\_EntryPoint\Thread;

/**
 * If `haxe.MainLoop` is kept from DCE, then we will insert an `haxe.EntryPoint.run()` call just at then end of `main()`.
 * This class can be redefined by custom frameworks so they can handle their own main loop logic.
 */
class EntryPoint {
	/**
	 * @var Mutex
	 */
	static public $mutex;
	/**
	 * @var \Array_hx
	 */
	static public $pending;
	/**
	 * @var Lock
	 */
	static public $sleepLock;
	/**
	 * @var int
	 */
	static public $threadCount = 0;

	/**
	 * @param \Closure $f
	 * 
	 * @return void
	 */
	public static function addThread ($f) {
		EntryPoint::$threadCount++;
		Thread::create(function () use (&$f) {
			$f();
			EntryPoint::$threadCount--;
		});
	}

	/**
	 * @return float
	 */
	public static function processEvents () {
		while (true) {
			$_this = EntryPoint::$pending;
			if ($_this->length > 0) {
				$_this->length--;
			}
			$f = array_shift($_this->arr);
			if ($f === null) {
				break;
			}
			$f();
		}
		$time = MainLoop::tick();
		if (!MainLoop::hasEvents() && (EntryPoint::$threadCount === 0)) {
			return -1;
		}
		return $time;
	}

	/**
	 * Start the main loop. Depending on the platform, this can return immediately or will only return when the application exits.
	 * 
	 * @return void
	 */
	public static function run () {
		while (!(EntryPoint::processEvents() < 0)) {
		}
	}

	/**
	 * @param \Closure $f
	 * 
	 * @return void
	 */
	public static function runInMainThread ($f) {
		$_this = EntryPoint::$pending;
		$_this->arr[$_this->length++] = $f;
	}

	/**
	 * Wakeup a sleeping `run()`
	 * 
	 * @return void
	 */
	public static function wakeup () {
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


		self::$sleepLock = new Lock();
		self::$mutex = new Mutex();
		self::$pending = new \Array_hx();
	}
}

Boot::registerClass(EntryPoint::class, 'haxe.EntryPoint');
EntryPoint::__hx__init();
