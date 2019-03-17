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
    public static function getUriNoQueryString()
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
    public static function appendLeadingSlash(string $url)
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
    public static function appendHttp(string $url)
    {
        $parsed = parse_url($url);
        if (empty($parsed['scheme'])) {
            $url = 'http://' . ltrim($url, '/');
        }

        return $url;
    }
}
