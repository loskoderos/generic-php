<?php

namespace Koderos\Generic\Model;

trait PopulateTrait
{
    /**
     * Populate object.
     * @param mixed $collection
     * @return PopulateTrait
     * @throws \ReflectionException
     */
    public function populate($collection): PopulateInterface
    {
        if (empty($collection)) {
            return $this;
        }
        if (is_object($collection) && method_exists($collection, 'toArray')) {
            $collection = $collection->toArray();
        }
        $reflector = new \ReflectionClass($this);
        foreach ($collection as $name => $value) {
            if ($reflector->hasProperty($name) && !$reflector->getProperty($name)->isStatic()) {
                $method = 'set'.ucfirst($name);
                if ($reflector->hasMethod($method)) {
                    $this->{$method}($value);
                } else {
                    $property = $reflector->getProperty($name);
                    $property->setAccessible(true);
                    $property->setValue($this, $value);
                }
            }
        }
        return $this;
    }
}
