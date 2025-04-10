<?php

namespace WebSK\Utils;

/**
 * Class Network
 * @package WebSK\Utils
 */
class Network
{
    /**
     * @param string $ip
     * @return bool
     */
    protected static function isPrivateNetwork(string $ip): bool
    {
        if (preg_match("/unknown/", $ip)) {
            return true;
        }
        if (preg_match("/127\.0\./", $ip)) {
            return true;
        }
        if (preg_match("/^192\.168\./", $ip)) {
            return true;
        }
        if (preg_match("/^10\./", $ip)) {
            return true;
        }
        if (preg_match("/^172\.16\./", $ip)) {
            return true;
        }
        if (preg_match("/^172\.17\./", $ip)) {
            return true;
        }
        if (preg_match("/^172\.18\./", $ip)) {
            return true;
        }
        if (preg_match("/^172\.19\./", $ip)) {
            return true;
        }
        if (preg_match("/^172\.20\./", $ip)) {
            return true;
        }
        if (preg_match("/^172\.21\./", $ip)) {
            return true;
        }
        if (preg_match("/^172\.22\./", $ip)) {
            return true;
        }
        if (preg_match("/^172\.23\./", $ip)) {
            return true;
        }
        if (preg_match("/^172\.24\./", $ip)) {
            return true;
        }
        if (preg_match("/^172\.25\./", $ip)) {
            return true;
        }
        if (preg_match("/^172\.26\./", $ip)) {
            return true;
        }
        if (preg_match("/^172\.27\./", $ip)) {
            return true;
        }
        if (preg_match("/^172\.28\./", $ip)) {
            return true;
        }
        if (preg_match("/^172\.29\./", $ip)) {
            return true;
        }
        if (preg_match("/^172\.30\./", $ip)) {
            return true;
        }
        if (preg_match("/^172\.31\./", $ip)) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    public static function getClientIpXff(): string
    {
        $remote_addr = $_SERVER['REMOTE_ADDR'];

        if (array_key_exists("HTTP_X_FORWARDED_FOR", $_SERVER) && $_SERVER['HTTP_X_FORWARDED_FOR']) {
            $list = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);

            foreach ($list as $ip) {
                if (self::isPrivateNetwork($ip)) {
                    break;
                }

                $remote_addr = $ip;
            }
        }

        return $remote_addr;
    }

    /**
     * @return string
     */
    public static function getClientIpRemoteAddr(): string
    {
        $remote_addr = $_SERVER['REMOTE_ADDR'] ?? '';

        return $remote_addr;
    }

    /**
     * @param string $net_or_ip
     * @return bool
     */
    public static function isValidNetOrIp(string $net_or_ip): bool
    {
        $is_valid = preg_match('@^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)(/([0-9]|[1-2][0-9]|3[0-2]))?$@', $net_or_ip);
        return boolval($is_valid);
    }

    /**
     * @param string $ip
     * @return bool
     */
    public static function isValidIp(string $ip): bool
    {
        return ip2long($ip) !== false;
    }

    /**
     * @param int $port
     * @return bool
     */
    public static function isValidPort(int $port): bool
    {
        return ($port >= 0) && ($port <= 65535);
    }

    /**
     * Проверка IP на вхождение в диапазон по маске сети
     * @param string $ip
     * @param array $subnet_mask_arr
     * @return bool
     */
    public static function checkIpBySubnetMask(string $ip, array $subnet_mask_arr): bool
    {
        foreach ($subnet_mask_arr as $network) {
            if (empty($network)) {
                continue;
            }
            $ip_arr = explode('/', $network);
            $network_long = ip2long($ip_arr[0]);

            $x = ip2long($ip_arr[1]);
            $mask = long2ip($x) == $ip_arr[1] ? $x : 0xffffffff << (32 - $ip_arr[1]);
            $ip_long = ip2long($ip);
            if (($ip_long & $mask) == ($network_long & $mask)) {
                return true;
            }
        }

        return false;
    }
}
