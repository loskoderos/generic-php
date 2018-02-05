<?php

namespace Generic\Collection;

class Collection implements CollectionInterface
{

    protected $collection = array();

    /**
     * Prepare collection.
     * @param array|object $collection
     */
    public function __construct($collection = null)
    {
        if (isset($collection)) {
            $this->populate($collection);
        }
    }

    /**
     * Add a value at the end of collection.
     * @param mixed $value
     * @return CollectionInterface
     */
    public function add($value)
    {
        return $this->set(null, $value);
    }

    /**
     * Set collection element.
     * @param mixed $name
     * @param mixed $value
     * @return Collection
     */
    public function set($name, $value)
    {
        if (isset($name)) {
            $this->collection[$name] = $value;
        } else {
            $this->collection[] = $value;
        }
        return $this;
    }

    /**
     * Get collection element.
     * @param mixed $name
     * @throws \UnexpectedValueException
     * @return mixed:
     */
    public function get($name, $defaultValue = null)
    {
        if (!isset($this->collection[$name])) {
            throw new \UnexpectedValueException("Missing collection item by key '{$name}'");
        }
        return $this->collection[$name];
    }

    /**
     * Check if collection has an element.
     * @param mixed $name
     * @return boolean
     */
    public function has($name)
    {
        return isset($this->collection[$name]);
    }

    /**
     * Remove an element from the collection.
     * @param mixed $name
     * @return Collection
     */
    public function remove($name)
    {
        unset($this->collection[$name]);
        return $this;
    }

    /**
     * Get collection items.
     * @return array
     */
    public function items()
    {
        return $this->collection;
    }

    /**
     * Alias to getAll.
     * @return array
     */
    public function toArray()
    {
        $array = array();
        foreach ($this->collection as $key => $item) {
            if (is_object($item)) {
                if (method_exists($item, 'toArray')) {
                    $value = $item->toArray();
                } else {
                    throw new \UnexpectedValueException("Nested object '{$key}' does not have toArray method");
                }
            } else {
                $value = $item;
            }
            $array[$key] = $value;
        }
        return $array;
    }

    /**
     * Clear collection.
     * @return Collection
     */
    public function clear()
    {
        $this->collection = array();
        return $this;
    }

    /**
     * Convert collection to single string.
     * @return string
     */
    public function __toString()
    {
        return var_export($this->collection, true);
    }

    /**
     * ArrayAccess
     * @param mixed $offset
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * ArrayAccess
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * ArrayAccess
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    /**
     * ArrayAccess
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        $this->remove($offset);
    }

    /**
     * Countable
     * @return int
     */
    public function count()
    {
        return count($this->collection);
    }

    /**
     * Serializable
     * @return string
     */
    public function serialize()
    {
        return serialize($this->toArray());
    }

    /**
     * Serializable
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        $this->populate(unserialize($serialized));
    }

    /**
     * IteratorAggregate
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->collection);
    }

    /**
     * Populate.
     * @param array|object $collection
     * @return Collection
     */
    public function populate($collection)
    {
        if (is_object($collection)) {
            if ($collection instanceof \IteratorAggregate) {
                $items = $collection;
            } else if (method_exists($collection, 'toArray')) {
                $items = $collection->toArray();
            } else {
                throw new CollectionException("Invalid collection parameter");
            }
        } else if (is_array($collection)) {
            $items = $collection;
        } else {
            throw new CollectionException("Invalid collection parameter");
        }
        foreach ($items as $name => $value) {
            $this->set($name, $value);
        }
        return $this;

    }

    /**
     * Reset pointer.
     * @return \Axon\Generic\Collection\Collection
     */
    public function reset()
    {
        reset($this->collection);
        return $this;
    }

    /**
     * Get first element.
     * @return mixed
     */
    public function first()
    {
        return $this->reset()->current();
    }

    /**
     * Get last element.
     * @return mixed
     */
    public function last()
    {
        return end($this->collection);
    }

    /**
     * Get current element.
     * @return mixed
     */
    public function current()
    {
        return current($this->collection);
    }

    /**
     * Get next element.
     * @return mixed
     */
    public function next()
    {
        return next($this->collection);
    }

    /**
     * Get previous element.
     * @return mixed
     */
    public function prev()
    {
        return prev($this->collection);
    }

    public function __set($key, $value)
    {
        return $this->set($key, $value);
    }

    public function __get($key)
    {
        return $this->get($key);
    }

    public function __isset($key)
    {
        return $this->has($key);
    }

    public function __unset($key)
    {
        $this->remove($key);
    }

}
