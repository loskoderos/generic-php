<?php

namespace Koderos\Generic\Model;

interface PopulateInterface
{
    /**
     * Populate object by a collection.
     * @param array $collection
     * @return PopulateInterface
     */
    public function populate(array $collection): PopulateInterface;
}
