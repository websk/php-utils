<?php

namespace WebSK\Utils;

/**
 * Class Sanitize
 * @package WebSK\Utils
 */
class Sanitize
{
    /**
     * @param string $value
     * @return string
     */
    public static function sanitizeTagContent(string $value)
    {
        $value = htmlspecialchars($value);

        return $value;
    }

    /**
     * @param string $url
     * @return string
     */
    public static function sanitizeUrl(string $url)
    {
        return filter_var($url, FILTER_SANITIZE_URL);
    }

    /**
     * @param null|string $value
     * @return string
     */
    public static function sanitizeAttrValue(?string $value)
    {
        if (is_null($value)) {
            return '';
        }

        return htmlspecialchars($value, ENT_QUOTES | ENT_HTML5);
    }

    /**
     * @param string $column_name
     * @return null|string|string[]
     */
    public static function sanitizeSqlColumnName(string $column_name){
        $column_name = preg_replace("/[^a-zA-Z0-9_]+/", "", $column_name);

        return $column_name;
    }
}
