<?php

namespace Generic\Collection;

use Generic\Object\PopulateInterface;
use Generic\Object\ToArrayInterface;

interface CollectionInterface
    extends
        PopulateInterface,
        ToArrayInterface,
        \ArrayAccess,
        \Countable,
        \Serializable,
        \IteratorAggregate
{
    /**
     * Clear items.
     * @return CollectionInterface
     */
    public function clear();

    /**
     * Get raw array with items.
     * @return array
     */
    public function items();

    /**
     * Add a value at the end of collection.
     * @param mixed $value
     * @return CollectionInterface
     */
    public function add($value);

    /**
     * Set key.
     * @param string|int $key
     * @param mixed $value
     */
    public function set($key, $value);

    /**
     * Get key.
     * @param string|int $key
     * @throws \UnexpectedValueException
     * @return mixed
     */
    public function get($key);

    /**
     * Has key?
     * @param string|int $key
     * @return boolean
     */
    public function has($key);

    /**
     * Remove key.
     * @param string|int $key
     * @return CollectionInterface
     */
    public function remove($key);

    /**
     * Reset collection pointer.
     * @return CollectionInterface
     */
    public function reset();

    /**
     * Get first element.
     * @return mixed
     */
    public function first();

    /**
     * Move pointer to the end and return last element.
     * @return mixed
     */
    public function last();

    /**
     * Get current element.
     * @return mixed
     */
    public function current();

    /**
     * Get next element.
     * @return mixed
     */
    public function next();

    /**
     * Get previous element.
     * @return mixed
     */
    public function prev();
}
