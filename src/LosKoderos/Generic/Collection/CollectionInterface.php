<?php

namespace LosKoderos\Generic\Collection;

use LosKoderos\Generic\Model\PopulateInterface;
use LosKoderos\Generic\Model\ToArrayInterface;

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
    public function clear(): CollectionInterface;

    /**
     * Get raw array with items.
     * @return array
     */
    public function items(): array;

    /**
     * Add a value at the end of collection.
     * @param mixed $value
     * @return CollectionInterface
     */
    public function add($value): CollectionInterface;

    /**
     * Set key.
     * @param string|int $key
     * @param mixed $value
     */
    public function set($key, $value): CollectionInterface;

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
    public function has($key): bool;

    /**
     * Remove key.
     * @param string|int $key
     * @return CollectionInterface
     */
    public function remove($key): CollectionInterface;

    /**
     * Reset collection pointer.
     * @return CollectionInterface
     */
    public function reset(): CollectionInterface;

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
