<?php
/**
 * Generated by Haxe 4.1.1
 */

namespace tink\io\_Worker;

use \tink\core\_Future\SyncFuture;
use \tink\core\_Lazy\LazyObject;
use \php\Boot;
use \tink\io\WorkerObject;
use \tink\core\_Lazy\LazyConst;
use \tink\core\FutureObject;

class EagerWorker implements WorkerObject {
	/**
	 * @return void
	 */
	public function __construct () {
	}

	/**
	 * @param LazyObject $task
	 * 
	 * @return FutureObject
	 */
	public function work ($task) {
		return new SyncFuture(new LazyConst($task->get()));
	}
}

Boot::registerClass(EagerWorker::class, 'tink.io._Worker.EagerWorker');