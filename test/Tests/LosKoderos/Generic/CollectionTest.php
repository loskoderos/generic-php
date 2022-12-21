<?php

namespace Tests\LosKoderos\Generic\Collection;

use PHPUnit\Framework\TestCase;
use LosKoderos\Generic\Collection\Collection;

class CollectionTest extends TestCase
{
    public function testConstruct()
    {
        $collection = new Collection();
        $this->assertEquals(0, count($collection));
    }

    public function testConstructWithArray()
    {
        $collection = new Collection(array(1, 2, 3));
        $this->assertEquals(3, count($collection));
    }

    public function testAdd()
    {
        $collection = new Collection();
        for ($i = 0; $i < 10; $i++) {
            $collection->add($i);
        }
        $this->assertEquals(10, count($collection));
        for ($i = 10; $i < 20; $i++) {
            $collection[$i] = $i;
        }
        $this->assertEquals(20, count($collection));
        for ($i = 0; $i < 20; $i++) {
            $this->assertEquals($i, $collection[$i]);
        }
    }

    public function testSetGetClearCollection()
    {
        $collection = new Collection();
        $this->assertEquals(0, count($collection->items()));

        $c = $collection->populate(array(1, 2, 3));
        $this->assertTrue($c instanceof Collection);
        $this->assertEquals(3, count($collection->items()));
        $this->assertEquals(3, count($collection));

        $c = $collection->clear();
        $this->assertTrue($c instanceof Collection);
        $this->assertEquals(0, count($collection->items()));
        $this->assertEquals(0, count($collection));
    }

    public function testSetGetHasRemoveCollectionElement()
    {
        $collection = new Collection();
        $this->assertEquals(0, count($collection));

        $c = $collection->set('a', 'xyz');
        $this->assertTrue($c instanceof Collection);
        $this->assertEquals(1, count($collection));
        $this->assertTrue(isset($collection['a']));
        $this->assertTrue($collection->has('a'));
        $this->assertEquals('xyz', $collection['a']);
        $this->assertEquals('xyz', $collection->get('a'));

        $c = $collection->remove('a');
        $this->assertTrue($c instanceof Collection);
        $this->assertEquals(0, count($collection));
        $this->assertFalse(isset($collection['a']));
        $this->assertFalse($collection->has('a'));

        $c = $collection->set('x', null);
        $this->assertTrue($c instanceof Collection);
        $this->assertFalse($c->has('x'));
    }

    public function testGetElementException()
    {
        $this->expectException('\UnexpectedValueException');
        $collection = new Collection();
        $collection->get('x');
    }

    public function testToString()
    {
        $collection = new Collection(array('abc' => 123));
        $this->assertStringContainsString("'abc' => 123", (string) $collection);
    }

    public function testSerialization()
    {
        $a = new Collection(array('abc' => 123, 'def' => 456));
        $str = $a->serialize();

        $b = new Collection();
        $b->unserialize($str);

        $this->assertEquals(123, $b->get('abc'));
        $this->assertEquals(456, $b->get('def'));
    }

    public function testIterator()
    {
        $collection = new Collection(array(1, 2, 3));
        $result = 0;
        foreach ($collection as $i) {
            $result += $i;
        }
        $this->assertEquals(6, $result);
    }

    public function testPopulateCollection()
    {
        $x = new Collection(array('a' => 123, 'b' => 456, 'c' => 789));
        $y = new Collection($x);
        $this->assertEquals(3, count($y));
        $this->assertEquals(123, $y['a']);
        $this->assertEquals(456, $y['b']);
        $this->assertEquals(789, $y['c']);
    }

    public function testResetFirstEndCurrentNextPrev()
    {
        $collection = new Collection([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
        $this->assertEquals(0, $collection->first());
        $this->assertEquals(9, $collection->last());

        $collection->reset();

        for ($i = 1; $i <= 8; $i++) {
            $x = $collection->next();
            $this->assertEquals($i, $collection->current());
            $this->assertEquals($x, $collection->current());
        }

        for ($i = 8; $i >= 1; $i--) {
            $x = $collection->prev();
            $this->assertEquals($i - 1, $collection->current());
            $this->assertEquals($x, $collection->current());
        }

        $this->assertEquals(9, $collection->last());
        $this->assertEquals(0, $collection->first());
    }

    public function testMagicAccessors()
    {
        $collection = new Collection();
        $this->assertFalse(isset($collection->xxx));
        $collection->xxx = 123;
        $this->assertTrue(isset($collection->xxx));
        $this->assertEquals(123, $collection->xxx);
        unset($collection->xxx);
        $this->assertFalse(isset($collection->xxx));
    }
}
