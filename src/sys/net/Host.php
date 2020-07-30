<?php
/**
 * Generated by Haxe 4.1.3
 */

namespace sys\net;

use \php\Boot;
use \php\_Boot\HxString;

/**
 * A given IP host name.
 */
class Host {
	/**
	 * @var string
	 */
	public $_ip;
	/**
	 * @var string
	 * The provided host string.
	 */
	public $host;
	/**
	 * @var int
	 * The actual IP corresponding to the host.
	 */
	public $ip;

	/**
	 * Returns the local computer host name
	 * 
	 * @return string
	 */
	public static function localhost () {
		return ($_SERVER["HTTP_HOST"] ?? "localhost");
	}

	/**
	 * Creates a new Host : the name can be an IP in the form "127.0.0.1" or an host name such as "google.com", in which case
	 * the corresponding IP address is resolved using DNS. An exception occur if the host name could not be found.
	 * 
	 * @param string $name
	 * 
	 * @return void
	 */
	public function __construct ($name) {
		$this->host = $name;
		if ((new \EReg("^(\\d{1,3}\\.){3}\\d{1,3}\$", ""))->match($name)) {
			$this->_ip = $name;
		} else {
			$this->_ip = \gethostbyname($name);
			if ($this->_ip === $name) {
				$this->ip = 0;
				return;
			}
		}
		$p = HxString::split($this->_ip, ".");
		$this->ip = \intval(\sprintf("%02X%02X%02X%02X", ($p->arr[3] ?? null), ($p->arr[2] ?? null), ($p->arr[1] ?? null), ($p->arr[0] ?? null)), 16);
	}

	/**
	 * Perform a reverse-DNS query to resolve a host name from an IP.
	 * 
	 * @return string
	 */
	public function reverse () {
		return \gethostbyaddr($this->_ip);
	}

	/**
	 * Returns the IP representation of the host
	 * 
	 * @return string
	 */
	public function toString () {
		return $this->_ip;
	}

	public function __toString() {
		return $this->toString();
	}
}

Boot::registerClass(Host::class, 'sys.net.Host');
