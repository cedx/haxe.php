<?php
/**
 * Generated by Haxe 4.1.2
 */

namespace tink\core;

use \tink\core\_Progress\Progress_Impl_;
use \tink\core\_Signal\Signal_Impl_;
use \php\Boot;
use \haxe\ds\Option as DsOption;

class ProgressTrigger extends CompositeProgress {
	/**
	 * @var FutureTrigger
	 */
	public $futureTrigger;
	/**
	 * @var SignalTrigger
	 */
	public $signalTrigger;
	/**
	 * @var ProgressType
	 */
	public $value;

	/**
	 * @return void
	 */
	public function __construct () {
		$this->value = ProgressType::InProgress(Progress_Impl_::$INIT);
		parent::__construct($this->futureTrigger = new FutureTrigger(), $this->signalTrigger = Signal_Impl_::trigger());
	}

	/**
	 * @return ProgressObject
	 */
	public function asProgress () {
		return $this;
	}

	/**
	 * @param mixed $v
	 * 
	 * @return void
	 */
	public function finish ($v) {
		if ($this->value->index !== 1) {
			$this->value = ProgressType::Finished($v);
			$this->futureTrigger->trigger($v);
		}
	}

	/**
	 * @param float $v
	 * @param DsOption $total
	 * 
	 * @return void
	 */
	public function progress ($v, $total) {
		$_g = $this->value;
		$__hx__switch = ($_g->index);
		if ($__hx__switch === 0) {
			$_g1 = $_g->params[0];
			if (!Boot::equal($_g1->a, $v) || !TotalTools::eq($_g1->b, $total)) {
				$pv = new MPair($v, $total);
				$this->value = ProgressType::InProgress($pv);
				$this->signalTrigger->handlers->invoke($pv);
			}
		} else if ($__hx__switch === 1) {
		}
	}
}

Boot::registerClass(ProgressTrigger::class, 'tink.core.ProgressTrigger');
