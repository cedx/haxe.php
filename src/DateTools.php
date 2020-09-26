<?php
/**
 * Generated by Haxe 4.1.4
 */

use \php\_Boot\HxAnon;
use \php\Boot;

/**
 * The DateTools class contains some extra functionalities for handling `Date`
 * instances and timestamps.
 * In the context of Haxe dates, a timestamp is defined as the number of
 * milliseconds elapsed since 1st January 1970.
 */
class DateTools {
	/**
	 * @var \Array_hx
	 */
	static public $DAYS_OF_MONTH;

	/**
	 * Converts a number of days to a timestamp.
	 * 
	 * @param float $n
	 * 
	 * @return float
	 */
	public static function days ($n) {
		return $n * 24.0 * 60.0 * 60.0 * 1000.0;
	}

	/**
	 * Returns the result of adding timestamp `t` to Date `d`.
	 * This is a convenience function for calling
	 * `Date.fromTime(d.getTime() + t)`.
	 * 
	 * @param \Date $d
	 * @param float $t
	 * 
	 * @return \Date
	 */
	public static function delta ($d, $t) {
		return \Date::fromTime($d->getTime() + $t);
	}

	/**
	 * Format the date `d` according to the format `f`. The format is
	 * compatible with the `strftime` standard format, except that there is no
	 * support in Flash and JS for day and months names (due to lack of proper
	 * internationalization API). On Haxe/Neko/Windows, some formats are not
	 * supported.
	 * ```haxe
	 * var t = DateTools.format(Date.now(), "%Y-%m-%d_%H:%M:%S");
	 * // 2016-07-08_14:44:05
	 * var t = DateTools.format(Date.now(), "%r");
	 * // 02:44:05 PM
	 * var t = DateTools.format(Date.now(), "%T");
	 * // 14:44:05
	 * var t = DateTools.format(Date.now(), "%F");
	 * // 2016-07-08
	 * ```
	 * 
	 * @param \Date $d
	 * @param string $f
	 * 
	 * @return string
	 */
	public static function format ($d, $f) {
		return strftime($f, (int)($d->__t));
	}

	/**
	 * Returns the number of days in the month of Date `d`.
	 * This method handles leap years.
	 * 
	 * @param \Date $d
	 * 
	 * @return int
	 */
	public static function getMonthDays ($d) {
		$month = $d->getMonth();
		$year = $d->getFullYear();
		if ($month !== 1) {
			return (DateTools::$DAYS_OF_MONTH->arr[$month] ?? null);
		}
		if (((($year % 4) === 0) && (($year % 100) !== 0)) || (($year % 400) === 0)) {
			return 29;
		} else {
			return 28;
		}
	}

	/**
	 * Converts a number of hours to a timestamp.
	 * 
	 * @param float $n
	 * 
	 * @return float
	 */
	public static function hours ($n) {
		return $n * 60.0 * 60.0 * 1000.0;
	}

	/**
	 * Build a date-time from several components
	 * 
	 * @param object $o
	 * 
	 * @return float
	 */
	public static function make ($o) {
		return $o->ms + 1000.0 * ($o->seconds + 60.0 * ($o->minutes + 60.0 * ($o->hours + 24.0 * $o->days)));
	}

	/**
	 * Retrieve Unix timestamp value from Date components. Takes same argument sequence as the Date constructor.
	 * 
	 * @param int $year
	 * @param int $month
	 * @param int $day
	 * @param int $hour
	 * @param int $min
	 * @param int $sec
	 * 
	 * @return float
	 */
	public static function makeUtc ($year, $month, $day, $hour, $min, $sec) {
		return gmmktime($hour, $min, $sec, $month + 1, $day, $year) * 1000;
	}

	/**
	 * Converts a number of minutes to a timestamp.
	 * 
	 * @param float $n
	 * 
	 * @return float
	 */
	public static function minutes ($n) {
		return $n * 60.0 * 1000.0;
	}

	/**
	 * Separate a date-time into several components
	 * 
	 * @param float $t
	 * 
	 * @return object
	 */
	public static function parse ($t) {
		$s = $t / 1000;
		$m = $s / 60;
		$h = $m / 60;
		$tmp = (int)((fmod($s, 60)));
		$tmp1 = (int)((fmod($m, 60)));
		$tmp2 = (int)((fmod($h, 24)));
		return new HxAnon([
			"ms" => fmod($t, 1000),
			"seconds" => $tmp,
			"minutes" => $tmp1,
			"hours" => $tmp2,
			"days" => (int)(($h / 24)),
		]);
	}

	/**
	 * Converts a number of seconds to a timestamp.
	 * 
	 * @param float $n
	 * 
	 * @return float
	 */
	public static function seconds ($n) {
		return $n * 1000.0;
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


		self::$DAYS_OF_MONTH = \Array_hx::wrap([
			31,
			28,
			31,
			30,
			31,
			30,
			31,
			31,
			30,
			31,
			30,
			31,
		]);
	}
}

Boot::registerClass(DateTools::class, 'DateTools');
DateTools::__hx__init();
