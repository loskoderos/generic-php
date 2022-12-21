<?php

namespace LosKoderos\Generic\Utils;

class ArrayUtils
{
    /**
     * Convert an array to an stdClass object.
     * @param array $array
     * @return \stdClass
     */
    public static function arrayToStdClass(array $array): \stdClass
    {
        $object = new \stdClass();
        foreach ($array as $k => $v) {
            if (!empty($k)) {
                $object->{$k} = self::_arrayElementValue($v);
            }
        }
        return $object;
    }
    
    /**
     * Convert array element.
     * @param mixed $v
     * @return array|type
     */
    protected static function _arrayElementValue($v)
    {
        if (is_array($v)) {
            if (!self::isAssocArray($v)) {
                $array = array();
                foreach ($v as $e) {
                    array_push($array, self::_arrayElementValue($e));
                }
                return $array;
            } else {
                return self::arrayToStdClass($v);
            }
        } else {
            return $v;
        }
    }
    
    /**
     * Check if array is an associative one.
     * @param array $array
     * @return bool
     */
    public static function isAssocArray(array $array): bool
    {
        return count(array_filter(array_keys($array), 'is_string')) > 0;
    }
}
