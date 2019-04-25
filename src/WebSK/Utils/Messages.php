<?php

namespace WebSK\Utils;

/**
 * Class Messages
 * @package WebSK\Utils
 */
class Messages
{
    const MESSAGES_COOKIE_NAME = 'messages';

    /**
     * @param string $key
     * @param string $value
     */
    protected static function setMessageValue(string $key, string $value)
    {
        $cookie_value_arr = self::getMessagesArr();

        if (!is_array($cookie_value_arr[$key])) {
            $cookie_value_arr[$key] = [];
        }

        array_push($cookie_value_arr[$key], $value);

        $value_serialize = serialize($cookie_value_arr);

        setcookie(self::MESSAGES_COOKIE_NAME , $value_serialize, 0, '/');
    }

    /**
     * @param string $message
     */
    public static function setError(string $message)
    {
        self::setMessageValue('danger', $message);
    }

    /**
     * @param string $message
     */
    public static function setWarning(string $message)
    {
        self::setMessageValue('warning', $message);
    }

    /**
     * @param $message
     */
    public static function setMessage($message)
    {
        self::setMessageValue('success', $message);
    }

    /**
     * @return string
     */
    public static function renderMessages()
    {
        $cookie_value_arr = self::getMessagesArr();

        $messages = '';
        foreach ($cookie_value_arr as $key => $messages_arr) {
            if (is_array($messages_arr)) {
                continue;
            }

            $messages .= '<p class="alert alert-' . $key . ' flash-' . $key . '">';
            foreach ($messages_arr as $message) {
                $messages .= $message . '<br>';
            }
            $messages .= "</p>";

            setcookie(self::MESSAGES_COOKIE_NAME , '', time() - 3600, '/');
        }

        return $messages;
    }

    /**
     * @return array
     */
    protected static function getMessagesArr()
    {
        if (!isset($_COOKIE)) {
            return [];
        }

        if (!array_key_exists(self::MESSAGES_COOKIE_NAME, $_COOKIE)) {
            return [];
        }

        $value_serialize = $_COOKIE[self::MESSAGES_COOKIE_NAME];
        $value_arr = unserialize($value_serialize);

        return $value_arr;
    }
}
