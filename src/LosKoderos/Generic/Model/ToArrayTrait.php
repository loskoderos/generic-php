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
                        if (method_exists($item, 'toArray')) {
                            $item = $item->toArray();
                        } else if ($item instanceof \DateTime) {
                            $item = $item->format(\DateTime::RFC3339);
                        } else {
                            $propertyName = $property->getName();
                            $objectClass = get_class($value);
                            throw new \UnexpectedValueException(
                                "Property {$propertyName}: ".
                                "Nested object of type {$objectClass} does not have toArray method");
                        }
                    }
                    $serialized[$key] = $item;
                }
                $value = $serialized;
            } else if (is_object($value)) {
                if (method_exists($value, 'toArray')) {
                    $value = $value->toArray();
                } else if ($value instanceof \DateTime) {
                    $value = $value->format(\DateTime::RFC3339);
                } else {
                    $propertyName = $property->getName();
                    $objectClass = get_class($value);
                    throw new \UnexpectedValueException(
                        "Property {$propertyName}: ".
                        "Nested object of type {$objectClass} does not have toArray method");
                }
            }
            $array[$property->getName()] = $value;
        }
        return $array;
    }
}
