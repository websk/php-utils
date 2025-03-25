<?php

namespace WebSK\Utils;

/**
 * Class Redirects
 * @package WebSK\Utils
 */
class Redirects
{

    /**
     * @param string $url
     */
    public static function redirect(string $url): void
    {
        header('Location: ' . $url);
        exit;
    }

    /**
     * @param string $url
     */
    public static function redirect301(string $url): void
    {
        header("HTTP/1.0 301 Moved Permanently");
        header('Location: ' . $url);
        exit;
    }
}
