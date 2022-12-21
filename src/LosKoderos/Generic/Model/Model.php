<?php

namespace LosKoderos\Generic\Model;

class Model implements PopulateInterface, ToArrayInterface
{
    use PopulateTrait;
    use ToArrayTrait;

    public function __construct($collection = null)
    {
        $this->populate($collection);
    }
}
