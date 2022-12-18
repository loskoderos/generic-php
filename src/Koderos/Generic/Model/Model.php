<?php

namespace Koderos\Generic\Model;

class Model implements PopulateInterface, ToArrayInterface
{
    use PopulateTrait;
    use ToArrayTrait;

    public function __construct($collection = null)
    {
        $this->populate($collection);
    }
}
