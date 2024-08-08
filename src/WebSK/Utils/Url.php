<?php

namespace WebSK\Utils;

/**
 * Class Url
 * @package WebSK\Utils
 */
class Url
{

    /**
     * @return string
     */
    public static function getUriNoQueryString(): string
    {
        $parts = array_key_exists('REQUEST_URI', $_SERVER) ? explode('?', $_SERVER['REQUEST_URI']) : [];

        if (!isset($parts[0])) {
            return '';
        }

        $parts_second = explode('&', $parts[0]);
        $uri = $parts_second[0] ?? '';

        return $uri;
    }

    /**
     * @param string $url
     * @return string
     */
    public static function appendLeadingSlash(string $url): string
    {
        // append leading slash
        if (substr($url, 0, 5) != 'http:') {
            if (substr($url, 0, 1) != '/') {
                $url = '/' . $url;
            }
        }

        return $url;
    }

    /**
     * @param string $url
     * @return string
     */
    public static function appendHttp(string $url): string
    {
        $parsed = parse_url($url);
        if (empty($parsed['scheme'])) {
            $url = 'http://' . ltrim($url, '/');
        }

        return $url;
    }

    public static function filterUrls(array $urls_arr): array
    {
        return array_filter($urls_arr, function ($url) {
            return self::filterUrl($url) !== false;
        });
    }

    /**
     * @param string $url
     * @return false|string
     */
    public static function filterUrl(string $url)
    {
        $filtered_url = filter_var($url, FILTER_SANITIZE_URL);
        return filter_var($filtered_url, FILTER_VALIDATE_URL);
    }

    /**
     * @param string $url
     * @return bool
     */
    public static function validateUrlWithScheme(string $url): bool
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            return false;
        }

        $url_scheme = parse_url($url, PHP_URL_SCHEME);

        if (!in_array($url_scheme, [HTTP::SCHEME_HTTP, HTTP::SCHEME_HTTPS])) {
            return false;
        }

        return true;
    }

    /**
     * @param array $url_parts_arr
     * @return string
     */
    public static function buildUrl(array $url_parts_arr): string
    {
        $url_parts_arr = array_map(function ($var) {
            return trim($var, '/');
        }, $url_parts_arr);

        return implode('/', $url_parts_arr);
    }
}
