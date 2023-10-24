<?php

namespace LosKoderos\Generic\Model;

trait ToArrayTrait
{
    /**
     * Convert object to array.
     * @return array
     * @throws \ReflectionException
     */
    public function toArray(): array
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
            if (is_array($value)) {
                $serialized = array();
                foreach ($value as $key => $item) {
                    if (is_object($item)) {
                        $item = Serializer::serialize($item);
                    }
                    $serialized[$key] = $item;
                }
                $value = $serialized;
            } else if (is_object($value)) {
                $value = Serializer::serialize($value);
            }
            $array[$property->getName()] = $value;
        }
        return $array;
    }
}
