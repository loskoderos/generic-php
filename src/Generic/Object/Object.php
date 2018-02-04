<?php

namespace Generic\Object;

class Object implements PopulateInterface, ToArrayInterface
{
    use PopulateTrait;
    use ToArrayTrait;
    
    public function __construct($collection = null)
    {
        $this->populate($collection);
    }
}
