<?php

namespace WebSK\Utils;

/**
 * Class FullObjectId
 * @package WebSK\Utils
 */
class FullObjectId
{
    /**
     * @param $obj
     * @return null|string
     */
    public static function getFullObjectId($obj): ?string
    {
        if (is_null($obj)) {
            return null;
        }

        if (!is_object($obj)) {
            return 'not_object';
        }

        $obj_id_parts = [];
        $obj_id_parts[] = get_class($obj);
        if (method_exists($obj, 'getId')) {
            $obj_id_parts[] = $obj->getId();
        }

        return implode('.', $obj_id_parts);
    }
}
