<?php

namespace WebSK\Utils;

/**
 * Class HTTP
 * @package WebSK\Utils
 */
class HTTP
{
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
