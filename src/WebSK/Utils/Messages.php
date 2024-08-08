<?php

namespace WebSK\Utils;

/**
 * Class Messages
 * @package WebSK\Utils
 */
class Messages
{
    const string MESSAGES_COOKIE_NAME = 'websk_flash_messages';

    const string MESSAGE_TYPE_ERROR = 'danger';
    const string MESSAGE_TYPE_WARNING = 'warning';
    const string MESSAGE_TYPE_SUCCESS = 'success';

    /**
     * @param string $message_type
     * @param string $value
     */
    protected static function setMessageValue(string $message_type, string $value)
    {
        $flash_messages_values_from_cookie_arr = self::getMessagesValuesFromCookieArr();

        if (!isset($flash_messages_values_from_cookie_arr[$message_type])) {
            $flash_messages_values_from_cookie_arr[$message_type] = [];
        }

        if (!is_array($flash_messages_values_from_cookie_arr[$message_type])) {
            $flash_messages_values_from_cookie_arr[$message_type] = [];
        }

        array_push($flash_messages_values_from_cookie_arr[$message_type], $value);

        $value_serialize = json_encode($flash_messages_values_from_cookie_arr);

        setcookie(self::MESSAGES_COOKIE_NAME , $value_serialize, 0, '/');
    }

    /**
     * @param string $message
     */
    public static function setError(string $message)
    {
        self::setMessageValue(self::MESSAGE_TYPE_ERROR, $message);
    }

    /**
     * @param string $message
     */
    public static function setWarning(string $message)
    {
        self::setMessageValue(self::MESSAGE_TYPE_WARNING, $message);
    }

    /**
     * @param string $message
     */
    public static function setMessage(string $message)
    {
        self::setMessageValue(self::MESSAGE_TYPE_SUCCESS, $message);
    }

    /**
     * @return string
     */
    public static function renderMessages(): string
    {
        $flash_messages_values_from_cookie_arr = self::getMessagesValuesFromCookieArr();

        $messages = '';
        foreach ($flash_messages_values_from_cookie_arr as $message_type => $messages_arr) {
            if (!is_array($messages_arr)) {
                continue;
            }

            $messages .= '<p class="alert alert-' . $message_type . ' flash-' . $message_type . '">';
            $messages .= implode('<br>', $messages_arr);
            $messages .= "</p>";
        }

        setcookie(self::MESSAGES_COOKIE_NAME , '', time() - 3600, '/');

        return $messages;
    }

    /**
     * @return array
     */
    protected static function getMessagesValuesFromCookieArr(): array
    {
        if (!isset($_COOKIE)) {
            return [];
        }

        if (!array_key_exists(self::MESSAGES_COOKIE_NAME, $_COOKIE)) {
            return [];
        }

        $value_serialize = $_COOKIE[self::MESSAGES_COOKIE_NAME];
        $value_arr = json_decode($value_serialize, true);

        if (!is_array($value_arr)) {
            return [];
        }

        return $value_arr;
    }
}
