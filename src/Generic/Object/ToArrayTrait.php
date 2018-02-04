<?php

namespace Generic\Object;

trait ToArrayTrait
{
    public function toArray()
    {
        $reflector = new \ReflectionClass($this);
        $properties = $reflector->getProperties();
        $array = array();
        foreach ($properties as $property) {
            if ($property->isStatic()) {
                continue;
            }
            $method = 'get'.ucfirst($property->getName());
            if ($reflector->hasMethod($method)) {
                $value = $this->{$method}();
            } else {
                $property->setAccessible(true);
                $value = $property->getValue($this);
            }
            if (is_object($value)) {
                if (method_exists($value, 'toArray')) {
                    $value = $value->toArray();
                } else {
                    throw new \UnexpectedValueException("Nested object does not have toArray method");
                }
            }
            $array[$property->getName()] = $value;
        }
        return $array;
    }
}
