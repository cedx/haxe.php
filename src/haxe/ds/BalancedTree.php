<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace haxe\ds;

use \php\Boot;
use \haxe\Exception;
use \haxe\iterators\MapKeyValueIterator;
use \haxe\IMap;
use \haxe\NativeStackTrace;
use \haxe\iterators\ArrayIterator;

/**
 * BalancedTree allows key-value mapping with arbitrary keys, as long as they
 * can be ordered. By default, `Reflect.compare` is used in the `compare`
 * method, which can be overridden in subclasses.
 * Operations have a logarithmic average and worst-case cost.
 * Iteration over keys and values, using `keys` and `iterator` respectively,
 * are in-order.
 */
class BalancedTree implements IMap {
	/**
	 * @var TreeNode
	 */
	public $root;

	/**
	 * @param TreeNode $node
	 * @param \Array_hx $acc
	 * 
	 * @return void
	 */
	public static function iteratorLoop ($node, $acc) {
		while (true) {
			if ($node !== null) {
				BalancedTree::iteratorLoop($node->left, $acc);
				$acc->arr[$acc->length++] = $node->value;
				$node = $node->right;
				continue;
			}
			return;
		}
	}

	/**
	 * Creates a new BalancedTree, which is initially empty.
	 * 
	 * @return void
	 */
	public function __construct () {
	}

	/**
	 * @param TreeNode $l
	 * @param mixed $k
	 * @param mixed $v
	 * @param TreeNode $r
	 * 
	 * @return TreeNode
	 */
	public function balance ($l, $k, $v, $r) {
		$hl = ($l === null ? 0 : $l->_height);
		$hr = ($r === null ? 0 : $r->_height);
		if ($hl > ($hr + 2)) {
			$_this = $l->left;
			$_this1 = $l->right;
			if ((($_this === null ? 0 : $_this->_height)) >= (($_this1 === null ? 0 : $_this1->_height))) {
				return new TreeNode($l->left, $l->key, $l->value, new TreeNode($l->right, $k, $v, $r));
			} else {
				return new TreeNode(new TreeNode($l->left, $l->key, $l->value, $l->right->left), $l->right->key, $l->right->value, new TreeNode($l->right->right, $k, $v, $r));
			}
		} else if ($hr > ($hl + 2)) {
			$_this = $r->right;
			$_this1 = $r->left;
			if ((($_this === null ? 0 : $_this->_height)) > (($_this1 === null ? 0 : $_this1->_height))) {
				return new TreeNode(new TreeNode($l, $k, $v, $r->left), $r->key, $r->value, $r->right);
			} else {
				return new TreeNode(new TreeNode($l, $k, $v, $r->left->left), $r->left->key, $r->left->value, new TreeNode($r->left->right, $r->key, $r->value, $r->right));
			}
		} else {
			return new TreeNode($l, $k, $v, $r, (($hl > $hr ? $hl : $hr)) + 1);
		}
	}

	/**
	 * Removes all keys from `this` BalancedTree.
	 * 
	 * @return void
	 */
	public function clear () {
		$this->root = null;
	}

	/**
	 * @param mixed $k1
	 * @param mixed $k2
	 * 
	 * @return int
	 */
	public function compare ($k1, $k2) {
		return \Reflect::compare($k1, $k2);
	}

	/**
	 * @return BalancedTree
	 */
	public function copy () {
		$copied = new BalancedTree();
		$copied->root = $this->root;
		return $copied;
	}

	/**
	 * Tells if `key` is bound to a value.
	 * This method returns true even if `key` is bound to null.
	 * If `key` is null, the result is unspecified.
	 * 
	 * @param mixed $key
	 * 
	 * @return bool
	 */
	public function exists ($key) {
		$node = $this->root;
		while ($node !== null) {
			$c = $this->compare($key, $node->key);
			if ($c === 0) {
				return true;
			} else if ($c < 0) {
				$node = $node->left;
			} else {
				$node = $node->right;
			}
		}
		return false;
	}

	/**
	 * Returns the value `key` is bound to.
	 * If `key` is not bound to any value, `null` is returned.
	 * If `key` is null, the result is unspecified.
	 * 
	 * @param mixed $key
	 * 
	 * @return mixed
	 */
	public function get ($key) {
		$node = $this->root;
		while ($node !== null) {
			$c = $this->compare($key, $node->key);
			if ($c === 0) {
				return $node->value;
			}
			if ($c < 0) {
				$node = $node->left;
			} else {
				$node = $node->right;
			}
		}
		return null;
	}

	/**
	 * Iterates over the bound values of `this` BalancedTree.
	 * This operation is performed in-order.
	 * 
	 * @return object
	 */
	public function iterator () {
		$ret = new \Array_hx();
		BalancedTree::iteratorLoop($this->root, $ret);
		return new ArrayIterator($ret);
	}

	/**
	 * See `Map.keyValueIterator`
	 * 
	 * @return object
	 */
	public function keyValueIterator () {
		return new MapKeyValueIterator($this);
	}

	/**
	 * Iterates over the keys of `this` BalancedTree.
	 * This operation is performed in-order.
	 * 
	 * @return object
	 */
	public function keys () {
		$ret = new \Array_hx();
		$this->keysLoop($this->root, $ret);
		return new ArrayIterator($ret);
	}

	/**
	 * @param TreeNode $node
	 * @param \Array_hx $acc
	 * 
	 * @return void
	 */
	public function keysLoop ($node, $acc) {
		if ($node !== null) {
			$this->keysLoop($node->left, $acc);
			$acc->arr[$acc->length++] = $node->key;
			$this->keysLoop($node->right, $acc);
		}
	}

	/**
	 * @param TreeNode $t1
	 * @param TreeNode $t2
	 * 
	 * @return TreeNode
	 */
	public function merge ($t1, $t2) {
		if ($t1 === null) {
			return $t2;
		}
		if ($t2 === null) {
			return $t1;
		}
		$t = $this->minBinding($t2);
		return $this->balance($t1, $t->key, $t->value, $this->removeMinBinding($t2));
	}

	/**
	 * @param TreeNode $t
	 * 
	 * @return TreeNode
	 */
	public function minBinding ($t) {
		if ($t === null) {
			throw Exception::thrown("Not_found");
		} else if ($t->left === null) {
			return $t;
		} else {
			return $this->minBinding($t->left);
		}
	}

	/**
	 * Removes the current binding of `key`.
	 * If `key` has no binding, `this` BalancedTree is unchanged and false is
	 * returned.
	 * Otherwise the binding of `key` is removed and true is returned.
	 * If `key` is null, the result is unspecified.
	 * 
	 * @param mixed $key
	 * 
	 * @return bool
	 */
	public function remove ($key) {
		try {
			$this->root = $this->removeLoop($key, $this->root);
			return true;
		} catch(\Throwable $_g) {
			NativeStackTrace::saveStack($_g);
			if (is_string(Exception::caught($_g)->unwrap())) {
				return false;
			} else {
				throw $_g;
			}
		}
	}

	/**
	 * @param mixed $k
	 * @param TreeNode $node
	 * 
	 * @return TreeNode
	 */
	public function removeLoop ($k, $node) {
		if ($node === null) {
			throw Exception::thrown("Not_found");
		}
		$c = $this->compare($k, $node->key);
		if ($c === 0) {
			return $this->merge($node->left, $node->right);
		} else if ($c < 0) {
			return $this->balance($this->removeLoop($k, $node->left), $node->key, $node->value, $node->right);
		} else {
			return $this->balance($node->left, $node->key, $node->value, $this->removeLoop($k, $node->right));
		}
	}

	/**
	 * @param TreeNode $t
	 * 
	 * @return TreeNode
	 */
	public function removeMinBinding ($t) {
		if ($t->left === null) {
			return $t->right;
		} else {
			return $this->balance($this->removeMinBinding($t->left), $t->key, $t->value, $t->right);
		}
	}

	/**
	 * Binds `key` to `value`.
	 * If `key` is already bound to a value, that binding disappears.
	 * If `key` is null, the result is unspecified.
	 * 
	 * @param mixed $key
	 * @param mixed $value
	 * 
	 * @return void
	 */
	public function set ($key, $value) {
		$this->root = $this->setLoop($key, $value, $this->root);
	}

	/**
	 * @param mixed $k
	 * @param mixed $v
	 * @param TreeNode $node
	 * 
	 * @return TreeNode
	 */
	public function setLoop ($k, $v, $node) {
		if ($node === null) {
			return new TreeNode(null, $k, $v, null);
		}
		$c = $this->compare($k, $node->key);
		if ($c === 0) {
			return new TreeNode($node->left, $k, $v, $node->right, ($node === null ? 0 : $node->_height));
		} else if ($c < 0) {
			return $this->balance($this->setLoop($k, $v, $node->left), $node->key, $node->value, $node->right);
		} else {
			$nr = $this->setLoop($k, $v, $node->right);
			return $this->balance($node->left, $node->key, $node->value, $nr);
		}
	}

	/**
	 * @return string
	 */
	public function toString () {
		if ($this->root === null) {
			return "{}";
		} else {
			return "{" . ($this->root->toString()??'null') . "}";
		}
	}

	public function __toString() {
		return $this->toString();
	}
}

Boot::registerClass(BalancedTree::class, 'haxe.ds.BalancedTree');
