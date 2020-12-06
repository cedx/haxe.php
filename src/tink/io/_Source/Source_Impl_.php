<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace tink\io\_Source;

use \tink\chunk\ChunkObject;
use \haxe\io\_BytesData\Container;
use \php\_Boot\HxAnon;
use \tink\core\_Future\SyncFuture;
use \haxe\ds\Option;
use \tink\io\SinkObject;
use \php\Boot;
use \tink\io\Transformer;
use \tink\streams\_Stream\Regrouper_Impl_;
use \tink\io\std\InputSource;
use \tink\streams\_Stream\Stream_Impl_;
use \tink\streams\Single;
use \tink\core\TypedError;
use \tink\streams\RegroupResult;
use \tink\streams\ReductionStep;
use \tink\streams\StreamObject;
use \tink\io\_Worker\Worker_Impl_;
use \tink\chunk\ByteChunk;
use \haxe\io\Input;
use \tink\core\_Lazy\LazyConst;
use \tink\streams\Empty_hx;
use \tink\streams\_Stream\Reducer_Impl_;
use \haxe\io\Bytes;
use \tink\_Chunk\Chunk_Impl_;
use \tink\core\FutureObject;

final class Source_Impl_ {
	/**
	 * @var StreamObject
	 */
	static public $EMPTY;

	/**
	 * @param StreamObject $this
	 * @param StreamObject $that
	 * 
	 * @return StreamObject
	 */
	public static function append ($this1, $that) {
		return $this1->append($that);
	}

	/**
	 * @param StreamObject $this
	 * 
	 * @return StreamObject
	 */
	public static function chunked ($this1) {
		return $this1;
	}

	/**
	 * @param StreamObject $s
	 * 
	 * @return FutureObject
	 */
	public static function concatAll ($s) {
		return $s->reduce(Chunk_Impl_::$EMPTY, Reducer_Impl_::ofSafe(function ($res, $cur) {
			return new SyncFuture(new LazyConst(ReductionStep::Progress(Chunk_Impl_::catChunk($res, $cur))));
		}));
	}

	/**
	 * @param StreamObject $this
	 * 
	 * @return StreamObject
	 */
	public static function dirty ($this1) {
		return $this1;
	}

	/**
	 * @param StreamObject $this
	 * 
	 * @return bool
	 */
	public static function get_depleted ($this1) {
		return $this1->get_depleted();
	}

	/**
	 * @param StreamObject $this
	 * @param int $len
	 * 
	 * @return StreamObject
	 */
	public static function limit ($this1, $len) {
		if ($len === 0) {
			return Source_Impl_::$EMPTY;
		}
		return $this1->regroup(Regrouper_Impl_::ofIgnoranceSync(function ($chunks) use (&$len) {
			if ($len <= 0) {
				return RegroupResult::Terminated(Option::None());
			}
			$chunk = ($chunks->arr[0] ?? null);
			$length = $chunk->getLength();
			$out = ($len === $length ? RegroupResult::Terminated(Option::Some(Stream_Impl_::single($chunk))) : RegroupResult::Converted(Stream_Impl_::single(($len < $length ? $chunk->slice(0, $len) : $chunk))));
			$len -= $length;
			return $out;
		}));
	}

	/**
	 * @param Bytes $b
	 * 
	 * @return StreamObject
	 */
	public static function ofBytes ($b) {
		return new Single(new LazyConst(ByteChunk::of($b)));
	}

	/**
	 * @param ChunkObject $chunk
	 * 
	 * @return StreamObject
	 */
	public static function ofChunk ($chunk) {
		return new Single(new LazyConst($chunk));
	}

	/**
	 * @param TypedError $e
	 * 
	 * @return StreamObject
	 */
	public static function ofError ($e) {
		return Stream_Impl_::ofError($e);
	}

	/**
	 * @param FutureObject $f
	 * 
	 * @return StreamObject
	 */
	public static function ofFuture ($f) {
		return Stream_Impl_::flatten($f);
	}

	/**
	 * @param string $name
	 * @param Input $input
	 * @param object $options
	 * 
	 * @return StreamObject
	 */
	public static function ofInput ($name, $input, $options = null) {
		if ($options === null) {
			$options = new HxAnon();
		}
		$tmp = Worker_Impl_::ensure($options->worker);
		$_g = $options->chunkSize;
		return new InputSource($name, $input, $tmp, Bytes::alloc(($_g === null ? 65536 : $_g)), 0);
	}

	/**
	 * @param FutureObject $p
	 * 
	 * @return StreamObject
	 */
	public static function ofPromised ($p) {
		return Stream_Impl_::flatten($p->map(function ($o) {
			$__hx__switch = ($o->index);
			if ($__hx__switch === 0) {
				return $o->params[0];
			} else if ($__hx__switch === 1) {
				return Source_Impl_::ofError($o->params[0]);
			}
		})->gather());
	}

	/**
	 * @param string $s
	 * 
	 * @return StreamObject
	 */
	public static function ofString ($s) {
		$b = \strlen($s);
		return new Single(new LazyConst(ByteChunk::of(new Bytes($b, new Container($s)))));
	}

	/**
	 * @param StreamObject $this
	 * @param SinkObject $target
	 * @param object $options
	 * 
	 * @return FutureObject
	 */
	public static function pipeTo ($this1, $target, $options = null) {
		return $target->consume($this1, $options);
	}

	/**
	 * @param StreamObject $this
	 * @param StreamObject $that
	 * 
	 * @return StreamObject
	 */
	public static function prepend ($this1, $that) {
		return $this1->prepend($that);
	}

	/**
	 * @param StreamObject $this
	 * @param int $len
	 * 
	 * @return StreamObject
	 */
	public static function skip ($this1, $len) {
		return $this1->regroup(Regrouper_Impl_::ofIgnoranceSync(function ($chunks) use (&$len) {
			$chunk = ($chunks->arr[0] ?? null);
			if ($len <= 0) {
				return RegroupResult::Converted(Stream_Impl_::single($chunk));
			}
			$length = $chunk->getLength();
			$out = ($len < $length ? Stream_Impl_::single($chunk->slice($len, $length)) : Empty_hx::$inst);
			$len -= $length;
			return RegroupResult::Converted($out);
		}));
	}

	/**
	 * @param StreamObject $this
	 * @param Transformer $transformer
	 * 
	 * @return StreamObject
	 */
	public static function transform ($this1, $transformer) {
		return $transformer->transform($this1);
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


		self::$EMPTY = Empty_hx::$inst;
	}
}

Boot::registerClass(Source_Impl_::class, 'tink.io._Source.Source_Impl_');
Boot::registerGetters('tink\\io\\_Source\\Source_Impl_', [
	'depleted' => true
]);
Source_Impl_::__hx__init();
