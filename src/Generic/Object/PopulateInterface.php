<?php

namespace Generic\Object;

interface PopulateInterface
{
    /**
     * Populate object by a collection.
     * @param CollectionInterface|array $collection
     * @return PopulateInterface
     */
    public function populate($collection);
}
