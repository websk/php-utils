<?php

namespace WebSK\Utils;

/**
 * Class Assert
 * @package WebSK\Utils
 */
class Assert
{
    /**
     * @param mixed $value
     * @param string $message
     * @return void
     * @throws \Exception
     */
    public static function assert(mixed $value, string $message = "", bool $debug = false): void
    {
        if ($value) {
            return;
        }

        $message = $message ?: 'Assertion failed';
        $code_file_and_line = '';

        $backtrace_arr = debug_backtrace();
        if (count($backtrace_arr) > 0) {
            $last_function_call_trace = $backtrace_arr[0];
            $code_file_and_line = "[" . $last_function_call_trace['file'] . ":" . $last_function_call_trace['line'] . "]";
        }

        $request_uri = '';
        if (array_key_exists('REQUEST_URI', $_SERVER)) {
            $request_uri = '[' . $_SERVER['REQUEST_URI'] . ']';
        }

        $message_arr = [$message];
        if ($code_file_and_line && $debug) {
            $message_arr[] = $code_file_and_line;
        }
        if ($request_uri && $debug) {
            $message_arr[] = $request_uri;
        }

        throw new \Exception(
            implode(" ", $message_arr)
        );
    }
}