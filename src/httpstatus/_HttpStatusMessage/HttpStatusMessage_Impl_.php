<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace httpstatus\_HttpStatusMessage;

use \php\Boot;

final class HttpStatusMessage_Impl_ {
	/**
	 * @param int $statusCode
	 * 
	 * @return string
	 */
	public static function _new ($statusCode) {
		return HttpStatusMessage_Impl_::fromCode($statusCode);
	}

	/**
	 * @param int $statusCode
	 * 
	 * @return string
	 */
	public static function fromCode ($statusCode) {
		if ($statusCode === 100) {
			return "Continue";
		} else if ($statusCode === 101) {
			return "Switching Protocols";
		} else if ($statusCode === 102) {
			return "Processing";
		} else if ($statusCode === 200) {
			return "OK";
		} else if ($statusCode === 201) {
			return "Created";
		} else if ($statusCode === 202) {
			return "Accepted";
		} else if ($statusCode === 203) {
			return "Non-Authoritative Information";
		} else if ($statusCode === 204) {
			return "No Content";
		} else if ($statusCode === 205) {
			return "Reset Content";
		} else if ($statusCode === 206) {
			return "Partial Content";
		} else if ($statusCode === 207) {
			return "Multi-Status";
		} else if ($statusCode === 208) {
			return "Already Reported";
		} else if ($statusCode === 226) {
			return "IM Used";
		} else if ($statusCode === 300) {
			return "Multiple Choices";
		} else if ($statusCode === 301) {
			return "Moved Permanently";
		} else if ($statusCode === 302) {
			return "Found";
		} else if ($statusCode === 303) {
			return "See Other";
		} else if ($statusCode === 304) {
			return "Not Modified";
		} else if ($statusCode === 305) {
			return "Use Proxy";
		} else if ($statusCode === 306) {
			return "Switch Proxy";
		} else if ($statusCode === 307) {
			return "Temporary Redirect";
		} else if ($statusCode === 308) {
			return "Permanent Redirect";
		} else if ($statusCode === 400) {
			return "Bad Request";
		} else if ($statusCode === 401) {
			return "Unauthorized";
		} else if ($statusCode === 402) {
			return "Payment Required";
		} else if ($statusCode === 403) {
			return "Forbidden";
		} else if ($statusCode === 404) {
			return "Not Found";
		} else if ($statusCode === 405) {
			return "Method Not Allowed";
		} else if ($statusCode === 406) {
			return "Not Acceptable";
		} else if ($statusCode === 407) {
			return "Proxy Authentication Required";
		} else if ($statusCode === 408) {
			return "Request Timeout";
		} else if ($statusCode === 409) {
			return "Conflict";
		} else if ($statusCode === 410) {
			return "Gone";
		} else if ($statusCode === 411) {
			return "Length Required";
		} else if ($statusCode === 412) {
			return "Precondition Failed";
		} else if ($statusCode === 413) {
			return "Payload Too Large";
		} else if ($statusCode === 414) {
			return "URI Too Long";
		} else if ($statusCode === 415) {
			return "Unsupported Media Type";
		} else if ($statusCode === 416) {
			return "Range Not Satisfiable";
		} else if ($statusCode === 417) {
			return "Expectation Failed";
		} else if ($statusCode === 418) {
			return "I'm a teapot";
		} else if ($statusCode === 421) {
			return "Misdirected Request";
		} else if ($statusCode === 422) {
			return "Unprocessable Entity";
		} else if ($statusCode === 423) {
			return "Locked";
		} else if ($statusCode === 424) {
			return "Failed Dependency";
		} else if ($statusCode === 426) {
			return "Upgrade Required";
		} else if ($statusCode === 428) {
			return "Precondition Required";
		} else if ($statusCode === 429) {
			return "Too Many Requests";
		} else if ($statusCode === 431) {
			return "Request Header Fields Too Large";
		} else if ($statusCode === 451) {
			return "Unavailable For Legal Reasons";
		} else if ($statusCode === 500) {
			return "Internal Server Error";
		} else if ($statusCode === 501) {
			return "Not Implemented";
		} else if ($statusCode === 502) {
			return "Bad Gateway";
		} else if ($statusCode === 503) {
			return "Service Unavailable";
		} else if ($statusCode === 504) {
			return "Gateway Timeout";
		} else if ($statusCode === 505) {
			return "HTTP Version Not Supported";
		} else if ($statusCode === 506) {
			return "Variant Also Negotiates";
		} else if ($statusCode === 507) {
			return "Insufficient Storage";
		} else if ($statusCode === 508) {
			return "Loop Detected";
		} else if ($statusCode === 510) {
			return "Not Extended";
		} else if ($statusCode === 511) {
			return "Network Authentication Required";
		} else {
			return "Unknown Status";
		}
	}
}

Boot::registerClass(HttpStatusMessage_Impl_::class, 'httpstatus._HttpStatusMessage.HttpStatusMessage_Impl_');
