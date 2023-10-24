<?php

namespace LosKoderos\Generic\Model;

final class Serializer
{
    protected static $serializers = [];

    protected function __construct() {}

    public static function register($classname, $callable)
    {
        self::$serializers[$classname] = $callable;
    }

    public static function unregister($classname)
    {
        unset(self::$serializers[$classname]);
    }

    public static function serialize($object)
    {
        if (!is_object($object)) return $object;

        $classname = get_class($object);
        if (isset(self::$serializers[$classname])) {
            $callable = self::$serializers[$classname];
            return call_user_func($callable, $object);
        }

        if (method_exists($object, 'toArray')) {
            return $object->toArray();
        }

        if (method_exists($object, 'toString')) {
            return $object->toString();
        }

        throw new \UnexpectedValueException("No serializer found for {$classname}");
    }
}
