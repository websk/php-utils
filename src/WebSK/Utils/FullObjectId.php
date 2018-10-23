<?php

namespace Websk\Utils;

/**
 * Class FullObjectId
 * @package Websk\Utils
 */
class FullObjectId
{
    /**
     * @param $obj
     * @return null|string
     */
    public static function getFullObjectId($obj)
    {
        if (is_null($obj)) {
            return null;
        }

        if (!is_object($obj)) {
            return 'not_object';
        }
        $obj_id_parts = array();
        $obj_id_parts[] = get_class($obj);
        if (method_exists($obj, 'getId')) {
            $obj_id_parts[] = $obj->getId();
        }

        return implode('.', $obj_id_parts);
    }
}
