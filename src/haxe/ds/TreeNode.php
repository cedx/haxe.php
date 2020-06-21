<?php
/**
 * Generated by Haxe 4.1.2
 */

namespace haxe\ds;

use \php\Boot;

/**
 * A tree node of `haxe.ds.BalancedTree`.
 */
class TreeNode {
	/**
	 * @var int
	 */
	public $_height;
	/**
	 * @var mixed
	 */
	public $key;
	/**
	 * @var TreeNode
	 */
	public $left;
	/**
	 * @var TreeNode
	 */
	public $right;
	/**
	 * @var mixed
	 */
	public $value;

	/**
	 * @param TreeNode $l
	 * @param mixed $k
	 * @param mixed $v
	 * @param TreeNode $r
	 * @param int $h
	 * 
	 * @return void
	 */
	public function __construct ($l, $k, $v, $r, $h = -1) {
		if ($h === null) {
			$h = -1;
		}
		$this->left = $l;
		$this->key = $k;
		$this->value = $v;
		$this->right = $r;
		if ($h === -1) {
			$tmp = null;
			$_this = $this->left;
			$_this1 = $this->right;
			if ((($_this === null ? 0 : $_this->_height)) > (($_this1 === null ? 0 : $_this1->_height))) {
				$_this = $this->left;
				$tmp = ($_this === null ? 0 : $_this->_height);
			} else {
				$_this = $this->right;
				$tmp = ($_this === null ? 0 : $_this->_height);
			}
			$this->_height = $tmp + 1;
		} else {
			$this->_height = $h;
		}
	}

	/**
	 * @return string
	 */
	public function toString () {
		return ((($this->left === null ? "" : ($this->left->toString()??'null') . ", "))??'null') . ("" . (\Std::string($this->key)??'null') . "=" . (\Std::string($this->value)??'null')) . ((($this->right === null ? "" : ", " . ($this->right->toString()??'null')))??'null');
	}

	public function __toString() {
		return $this->toString();
	}
}

Boot::registerClass(TreeNode::class, 'haxe.ds.TreeNode');
