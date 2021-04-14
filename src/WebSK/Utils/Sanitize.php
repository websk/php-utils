<?php

namespace WebSK\Utils;

/**
 * Class Sanitize
 * @package WebSK\Utils
 */
class Sanitize
{
    /**
     * @param null|string $value
     * @return string
     */
    public static function sanitizeTagContent(?string $value): string
    {
        return htmlspecialchars($value);
    }

    /**
     * @param string $url
     * @return string
     */
    public static function sanitizeUrl(string $url): string
    {
        return filter_var($url, FILTER_SANITIZE_URL);
    }

    /**
     * @param null|string $value
     * @return string
     */
    public static function sanitizeAttrValue(?string $value): string
    {
        if (is_null($value)) {
            return '';
        }

        return htmlspecialchars($value, ENT_QUOTES | ENT_HTML5);
    }

    /**
     * @param string $column_name
     * @return string
     */
    public static function sanitizeSqlColumnName(string $column_name): string
    {
        return preg_replace("/[^a-zA-Z0-9_]+/", "", $column_name);
    }
}
