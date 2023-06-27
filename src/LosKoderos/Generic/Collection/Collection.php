<?php

namespace LosKoderos\Generic\Collection;

class Collection implements CollectionInterface
{

    protected array $collection = array();
    protected $validator;
    protected $filter;

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
     * Set validator.
     * Validator function must return false to trigger an exception when an element is set.
     * @param callable $validator
     * @return Collection
     */
    public function setValidator(callable $validator): Collection
    {
        $this->validator = $validator;
        return $this;
    }

    /**
     * Get validator.
     * @return callable
     */
    public function getValidator(): callable
    {
        return $this->validator;
    }

    /**
     * Set filter.
     * Filter function returns a new filtered value.
     * @param callable $filter
     * @return Collection
     */
    public function setFilter(callable $filter): Collection
    {
        $this->filter = $filter;
        return $this;
    }

    /**
     * Get filter.
     * @return callable
     */
    public function getFilter(): callable
    {
        return $this->filter;
    }

    /**
     * Add a value at the end of collection.
     * @param mixed $value
     * @return CollectionInterface
     */
    public function add($value): CollectionInterface
    {
        return $this->set(null, $value);
    }

    /**
     * Set collection element.
     * @param mixed $name
     * @param mixed $value
     * @return Collection
     */
    public function set($name, $value): CollectionInterface
    {
        if (isset($this->filter) && is_callable($this->filter)) {
            $value = call_user_func($this->filter, $value);
        }
        if (isset($this->validator) && is_callable($this->validator)) {
            if (false == call_user_func($this->validator, $value)) {
                throw new \UnexpectedValueException("Invalid value");
            }
        }
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
    public function has($name): bool
    {
        return isset($this->collection[$name]);
    }

    /**
     * Remove an element from the collection.
     * @param mixed $name
     * @return Collection
     */
    public function remove($name): CollectionInterface
    {
        unset($this->collection[$name]);
        return $this;
    }

    /**
     * Get collection items.
     * @return array
     */
    public function items(): array
    {
        return $this->collection;
    }

    /**
     * Alias to getAll.
     * @return array
     */
    public function toArray(): array
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
     * @return CollectionInterface
     */
    public function clear(): CollectionInterface
    {
        $this->collection = array();
        return $this;
    }

    /**
     * Convert collection to single string.
     * @return string
     */
    public function __toString(): string
    {
        return var_export($this->collection, true);
    }

    /**
     * ArrayAccess
     * @param mixed $offset
     * @return boolean
     */
    public function offsetExists(mixed $offset): bool
    {
        return $this->has($offset);
    }

    /**
     * ArrayAccess
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->get($offset);
    }

    /**
     * ArrayAccess
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->set($offset, $value);
    }

    /**
     * ArrayAccess
     * @param mixed $offset
     */
    public function offsetUnset(mixed $offset): void
    {
        $this->remove($offset);
    }

    /**
     * Countable
     * @return int
     */
    public function count(): int
    {
        return count($this->collection);
    }

    /**
     * Serializable
     * @return string
     */
    public function serialize(): string
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
     * Compatibility with PHP 8.
     * @return array
     */
    public function __serialize(): array
    {
        return $this->toArray();
    }

    /**
     * Compatibility with PHP 8.
     * @param array $data
     * @return void
     */
    public function __unserialize(array $data): void 
    {
        $this->populate($data);
    }

    /**
     * IteratorAggregate
     * @return \ArrayIterator
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->collection);
    }

    /**
     * Populate.
     * @param array|object $collection
     * @return CollectionInterface
     */
    public function populate($collection): CollectionInterface
    {
        if (is_object($collection)) {
            if ($collection instanceof \IteratorAggregate) {
                $items = $collection;
            } else if (method_exists($collection, 'toArray')) {
                $items = $collection->toArray();
            } else {
                throw new \UnexpectedValueException("Invalid collection parameter");
            }
        } else if (is_array($collection)) {
            $items = $collection;
        } else {
            throw new \UnexpectedValueException("Invalid collection parameter");
        }
        foreach ($items as $name => $value) {
            $this->set($name, $value);
        }
        return $this;

    }

    /**
     * Reset pointer.
     * @return CollectionInterface
     */
    public function reset(): CollectionInterface
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
