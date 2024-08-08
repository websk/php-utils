<?php

namespace WebSK\Utils;

/**
 * Class HTTP
 * @package WebSK\Utils
 */
class HTTP
{
    const string METHOD_GET = 'GET';
    const string METHOD_POST = 'POST';
    const string METHOD_PUT = 'PUT';
    const string METHOD_DELETE = 'DELETE';

    const int STATUS_CONTINUE = 100;
    const int STATUS_SWITCHING_PROTOCOLS = 101;
    const int STATUS_PROCESSING = 102;            // RFC2518
    const int STATUS_OK = 200;
    const int STATUS_CREATED = 201;
    const int STATUS_ACCEPTED = 202;
    const int STATUS_NON_AUTHORITATIVE_INFORMATION = 203;
    const int STATUS_NO_CONTENT = 204;
    const int STATUS_RESET_CONTENT = 205;
    const int STATUS_PARTIAL_CONTENT = 206;
    const int STATUS_MULTI_STATUS = 207;          // RFC4918
    const int STATUS_ALREADY_REPORTED = 208;      // RFC5842
    const int STATUS_IM_USED = 226;               // RFC3229
    const int STATUS_MULTIPLE_CHOICES = 300;
    const int STATUS_MOVED_PERMANENTLY = 301;
    const int STATUS_FOUND = 302;
    const int STATUS_SEE_OTHER = 303;
    const int STATUS_NOT_MODIFIED = 304;
    const int STATUS_USE_PROXY = 305;
    const int STATUS_RESERVED = 306;
    const int STATUS_TEMPORARY_REDIRECT = 307;
    const int STATUS_PERMANENTLY_REDIRECT = 308;  // RFC7238
    const int STATUS_BAD_REQUEST = 400;
    const int STATUS_UNAUTHORIZED = 401;
    const int STATUS_PAYMENT_REQUIRED = 402;
    const int STATUS_FORBIDDEN = 403;
    const int STATUS_NOT_FOUND = 404;
    const int STATUS_METHOD_NOT_ALLOWED = 405;
    const int STATUS_NOT_ACCEPTABLE = 406;
    const int STATUS_PROXY_AUTHENTICATION_REQUIRED = 407;
    const int STATUS_REQUEST_TIMEOUT = 408;
    const int STATUS_CONFLICT = 409;
    const int STATUS_GONE = 410;
    const int STATUS_LENGTH_REQUIRED = 411;
    const int STATUS_PRECONDITION_FAILED = 412;
    const int STATUS_REQUEST_ENTITY_TOO_LARGE = 413;
    const int STATUS_REQUEST_URI_TOO_LONG = 414;
    const int STATUS_UNSUPPORTED_MEDIA_TYPE = 415;
    const int STATUS_REQUESTED_RANGE_NOT_SATISFIABLE = 416;
    const int STATUS_EXPECTATION_FAILED = 417;
    const int STATUS_I_AM_A_TEAPOT = 418;                                               // RFC2324
    const int STATUS_MISDIRECTED_REQUEST = 421;                                         // RFC7540
    const int STATUS_UNPROCESSABLE_ENTITY = 422;                                        // RFC4918
    const int STATUS_LOCKED = 423;                                                      // RFC4918
    const int STATUS_FAILED_DEPENDENCY = 424;                                           // RFC4918
    const int STATUS_RESERVED_FOR_WEBDAV_ADVANCED_COLLECTIONS_EXPIRED_PROPOSAL = 425;   // RFC2817
    const int STATUS_UPGRADE_REQUIRED = 426;                                            // RFC2817
    const int STATUS_PRECONDITION_REQUIRED = 428;                                       // RFC6585
    const int STATUS_TOO_MANY_REQUESTS = 429;                                           // RFC6585
    const int STATUS_REQUEST_HEADER_FIELDS_TOO_LARGE = 431;                             // RFC6585
    const int STATUS_UNAVAILABLE_FOR_LEGAL_REASONS = 451;
    const int STATUS_INTERNAL_SERVER_ERROR = 500;
    const int STATUS_NOT_IMPLEMENTED = 501;
    const int STATUS_BAD_GATEWAY = 502;
    const int STATUS_SERVICE_UNAVAILABLE = 503;
    const int STATUS_GATEWAY_TIMEOUT = 504;
    const int STATUS_VERSION_NOT_SUPPORTED = 505;
    const int STATUS_VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL = 506;                        // RFC2295
    const int STATUS_INSUFFICIENT_STORAGE = 507;                                        // RFC4918
    const int STATUS_LOOP_DETECTED = 508;                                               // RFC5842
    const int STATUS_NOT_EXTENDED = 510;                                                // RFC2774
    const int STATUS_NETWORK_AUTHENTICATION_REQUIRED = 511;                             // RFC6585

    const string HEADER_ACCESS_CONTROL_ALLOW_ORIGIN = 'Access-Control-Allow-Origin';
    const string HEADER_ORIGIN = 'Origin';
    const string HEADER_CONTENT_TYPE = 'Content-Type';
    const string HEADER_CONTENT_DISPOSITION = 'Content-Disposition';
    const string HEADER_CONTENT_LENGTH = 'Content-Length';
    const string HEADER_CACHE_CONTROL = 'Cache-Control';
    const string HEADER_EXPIRES = 'Expires';
    const string HEADER_PRAGMA = 'Pragma';
    const string HEADER_ACCEPT_RANGES = 'Accept-Ranges';

    const string CHARSET_UTF8 = 'charset=utf-8';

    const string MIME_TEXT_PLAIN = 'text/plain';
    const string CONTENT_TYPE_TEXT_PLAIN_WITH_CHARSET_UTF8 = self::MIME_TEXT_PLAIN . ';' . self::CHARSET_UTF8;

    const string MIME_APPLICATION_OPENXMLFORMATS_SPREADSHEETML = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
    const string CONTENT_TYPE_APPLICATION_OPENXMLFORMATS_SPREADSHEETML_WITH_CHARSET_UTF8 = self::MIME_APPLICATION_OPENXMLFORMATS_SPREADSHEETML . ';' . self::CHARSET_UTF8;

    const string MIME_TEXT_CSV = 'text/csv';
    const string CONTENT_TYPE_TEXT_CSV_WITH_CHARSET_UTF8 = self::MIME_TEXT_CSV . ';' . self::CHARSET_UTF8;

    const string MIME_TYPE_AUDIO_MP4 = 'audio/mp4';
    const string MIME_TYPE_APPLICATION_MP4 = 'application/mp4';
    const string MIME_TYPE_VIDEO_MP4 = 'video/mp4';

    const string HEADER_VALUE_NO_CACHE = 'no-cache';
    const string HEADER_VALUE_CACHE_CONTROL_MUST_REVALIDATE = 'must-revalidate, post-check=0, pre-check=0';

    const int CACHE_HEADERS_SEC = 60;

    const string SCHEME_HTTP = 'http';
    const string SCHEME_HTTPS = 'https';

    /**
     * @param int $cache_sec
     * @return void
     */
    public static function cacheHeaders(int $cache_sec = self::CACHE_HEADERS_SEC): void
    {
        header(self::HEADER_EXPIRES . ': ' . gmdate('D, d M Y H:i:s', time() + $cache_sec) . ' GMT');
        header(self::HEADER_CACHE_CONTROL . ': max-age=' . $cache_sec . ', public');
    }
}
