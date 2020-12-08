<?php
/**
 * Generated by Haxe 4.1.4
 */

namespace asys\io;

use \php\_Boot\HxAnon;
use \tink\core\_Future\SyncFuture;
use \tink\io\SinkObject;
use \php\Boot;
use \tink\io\std\InputSource;
use \haxe\Exception;
use \tink\core\Noise;
use \tink\core\TypedError;
use \tink\streams\StreamObject;
use \tink\io\_Worker\Worker_Impl_;
use \tink\core\Outcome;
use \tink\core\_Lazy\LazyConst;
use \sys\io\File as IoFile;
use \tink\io\_Sink\SinkYielding_Impl_;
use \haxe\io\Bytes;
use \haxe\NativeStackTrace;
use \tink\core\FutureObject;

class File {
	/**
	 * @param string $path
	 * @param bool $binary
	 * 
	 * @return FutureObject
	 */
	public static function append ($path, $binary = true) {
		if ($binary === null) {
			$binary = true;
		}
		$v = null;
		try {
			$v = Outcome::Success(IoFile::append($path, $binary));
		} catch(\Throwable $_g) {
			NativeStackTrace::saveStack($_g);
			$v1 = "" . (\Std::string(Exception::caught($_g)->unwrap())??'null');
			$v = Outcome::Failure(new TypedError(null, $v1, new HxAnon([
				"fileName" => "asys/io/File.hx",
				"lineNumber" => 259,
				"className" => "asys.io.File",
				"methodName" => "append",
			])));
		}
		return new SyncFuture(new LazyConst($v));
	}

	/**
	 * @param string $srcPath
	 * @param string $dstPath
	 * 
	 * @return FutureObject
	 */
	public static function copy ($srcPath, $dstPath) {
		$v = null;
		try {
			IoFile::copy($srcPath, $dstPath);
			$v = Outcome::Success(Noise::Noise());
		} catch(\Throwable $_g) {
			NativeStackTrace::saveStack($_g);
			$v1 = "" . (\Std::string(Exception::caught($_g)->unwrap())??'null');
			$v = Outcome::Failure(new TypedError(null, $v1, new HxAnon([
				"fileName" => "asys/io/File.hx",
				"lineNumber" => 268,
				"className" => "asys.io.File",
				"methodName" => "copy",
			])));
		}
		return new SyncFuture(new LazyConst($v));
	}

	/**
	 * @param string $path
	 * 
	 * @return FutureObject
	 */
	public static function getBytes ($path) {
		$v = null;
		try {
			$v = Outcome::Success(IoFile::getBytes($path));
		} catch(\Throwable $_g) {
			NativeStackTrace::saveStack($_g);
			$v1 = "" . (\Std::string(Exception::caught($_g)->unwrap())??'null');
			$v = Outcome::Failure(new TypedError(null, $v1, new HxAnon([
				"fileName" => "asys/io/File.hx",
				"lineNumber" => 232,
				"className" => "asys.io.File",
				"methodName" => "getBytes",
			])));
		}
		return new SyncFuture(new LazyConst($v));
	}

	/**
	 * @param string $path
	 * 
	 * @return FutureObject
	 */
	public static function getContent ($path) {
		$v = null;
		try {
			$v = Outcome::Success(IoFile::getContent($path));
		} catch(\Throwable $_g) {
			NativeStackTrace::saveStack($_g);
			$v1 = "" . (\Std::string(Exception::caught($_g)->unwrap())??'null');
			$v = Outcome::Failure(new TypedError(null, $v1, new HxAnon([
				"fileName" => "asys/io/File.hx",
				"lineNumber" => 217,
				"className" => "asys.io.File",
				"methodName" => "getContent",
			])));
		}
		return new SyncFuture(new LazyConst($v));
	}

	/**
	 * @param string $path
	 * @param bool $binary
	 * 
	 * @return FutureObject
	 */
	public static function read ($path, $binary = true) {
		if ($binary === null) {
			$binary = true;
		}
		$v = null;
		try {
			$v = Outcome::Success(IoFile::read($path, $binary));
		} catch(\Throwable $_g) {
			NativeStackTrace::saveStack($_g);
			$v1 = "" . (\Std::string(Exception::caught($_g)->unwrap())??'null');
			$v = Outcome::Failure(new TypedError(null, $v1, new HxAnon([
				"fileName" => "asys/io/File.hx",
				"lineNumber" => 247,
				"className" => "asys.io.File",
				"methodName" => "read",
			])));
		}
		return new SyncFuture(new LazyConst($v));
	}

	/**
	 * @param string $path
	 * @param bool $binary
	 * 
	 * @return StreamObject
	 */
	public static function readStream ($path, $binary = true) {
		if ($binary === null) {
			$binary = true;
		}
		$input = IoFile::read($path);
		$options = null;
		$options = new HxAnon();
		$tmp = Worker_Impl_::ensure($options->worker);
		$_g = $options->chunkSize;
		return new InputSource("asys read stream", $input, $tmp, Bytes::alloc(($_g === null ? 65536 : $_g)), 0);
	}

	/**
	 * @param string $path
	 * @param Bytes $bytes
	 * 
	 * @return FutureObject
	 */
	public static function saveBytes ($path, $bytes) {
		$v = null;
		try {
			IoFile::saveBytes($path, $bytes);
			$v = Outcome::Success(Noise::Noise());
		} catch(\Throwable $_g) {
			NativeStackTrace::saveStack($_g);
			$v1 = "" . (\Std::string(Exception::caught($_g)->unwrap())??'null');
			$v = Outcome::Failure(new TypedError(null, $v1, new HxAnon([
				"fileName" => "asys/io/File.hx",
				"lineNumber" => 241,
				"className" => "asys.io.File",
				"methodName" => "saveBytes",
			])));
		}
		return new SyncFuture(new LazyConst($v));
	}

	/**
	 * @param string $path
	 * @param string $content
	 * 
	 * @return FutureObject
	 */
	public static function saveContent ($path, $content) {
		$v = null;
		try {
			IoFile::saveContent($path, $content);
			$v = Outcome::Success(Noise::Noise());
		} catch(\Throwable $_g) {
			NativeStackTrace::saveStack($_g);
			$v1 = "" . (\Std::string(Exception::caught($_g)->unwrap())??'null');
			$v = Outcome::Failure(new TypedError(null, $v1, new HxAnon([
				"fileName" => "asys/io/File.hx",
				"lineNumber" => 226,
				"className" => "asys.io.File",
				"methodName" => "saveContent",
			])));
		}
		return new SyncFuture(new LazyConst($v));
	}

	/**
	 * @param string $path
	 * @param bool $binary
	 * 
	 * @return FutureObject
	 */
	public static function write ($path, $binary = true) {
		if ($binary === null) {
			$binary = true;
		}
		$v = null;
		try {
			$v = Outcome::Success(IoFile::write($path, $binary));
		} catch(\Throwable $_g) {
			NativeStackTrace::saveStack($_g);
			$v1 = "" . (\Std::string(Exception::caught($_g)->unwrap())??'null');
			$v = Outcome::Failure(new TypedError(null, $v1, new HxAnon([
				"fileName" => "asys/io/File.hx",
				"lineNumber" => 253,
				"className" => "asys.io.File",
				"methodName" => "write",
			])));
		}
		return new SyncFuture(new LazyConst($v));
	}

	/**
	 * @param string $path
	 * @param bool $binary
	 * 
	 * @return SinkObject
	 */
	public static function writeStream ($path, $binary = true) {
		if ($binary === null) {
			$binary = true;
		}
		return SinkYielding_Impl_::ofOutput("asys write stream", IoFile::write($path));
	}
}

Boot::registerClass(File::class, 'asys.io.File');
