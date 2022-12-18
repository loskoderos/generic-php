<?php

namespace Tests\Koderos\Generic;

use PHPUnit\Framework\TestCase;
use Koderos\Generic\Collection\Collection;
use Koderos\Generic\Model\Model;
use Koderos\Generic\Utils\ArrayUtils;

class MockItemModel extends Model
{
    public $value;
}

class ArrayUtilsMockModel extends Model
{
    public $x;
    protected $y;
    private $z;
    protected $set;
    protected $map;
    protected $items;
    
    public function __construct()
    {
        $this->x = 123;
        $this->y = 'abc';
        $this->z = 0.123;
        
        $this->set = new Collection();
        for ($i = 0; $i < 3; $i++) {
            $this->set->add($i);
        }
        
        $this->map = new Collection();
        $this->map->foo = 'bar';
        $this->map->xyz = 666;
        $this->map->item = new MockItemModel(['value' => True]);
        
        $this->items = new Collection();
        for ($i = 0; $i < 3; $i++) {
            $this->items->add(new MockItemModel(['value' => $i]));
        }
    }
}

class ArrayUtilsTest extends TestCase
{
    public function testArrayToSmartObjectConversion()
    {
        $mock = new ArrayUtilsMockModel();
        $o = ArrayUtils::arrayToStdClass($mock->toArray());
        $this->assertTrue($o instanceof \stdClass);

        $this->assertEquals(123, $o->x);
        $this->assertEquals('abc', $o->y);
        $this->assertEquals(0.123, $o->z);
        
        for ($i = 0; $i < 3; $i++) {
            $this->assertEquals($i, $o->set[$i]);
        }
        
        $this->assertEquals('bar', $o->map->foo);
        $this->assertEquals(666, $o->map->xyz);
        $this->assertTrue($o->map->item->value);
        
        for ($i = 0; $i < 3; $i++) {
            $this->assertEquals($i, $o->items[$i]->value);
        }
    }
}
