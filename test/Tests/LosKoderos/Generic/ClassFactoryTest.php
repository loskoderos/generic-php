<?php

namespace Tests\LosKoderos\Generic;

use PHPUnit\Framework\TestCase;
use LosKoderos\Generic\ClassFactory\ClassFactory;

class ClassFactoryTest extends TestCase
{
    public function testClassFactoryObject()
    {
        ClassFactory::clear();
        ClassFactory::override(['x' => 'y']);
        $x = ClassFactory::get('x');
        $this->assertEquals('y', $x);
        $this->assertTrue(ClassFactory::has('x'));
        $this->assertFalse(ClassFactory::has('y'));

        $this->assertFalse(ClassFactory::has(\stdClass::class));
        $o = ClassFactory::new(\stdClass::class);
        $this->assertInstanceOf(\stdClass::class, $o);

        ClassFactory::set('xxx', \stdClass::class);
        $this->assertTrue(ClassFactory::has('xxx'));
        $o = ClassFactory::new('xxx');
        $this->assertInstanceOf(\stdClass::class, $o);

        ClassFactory::remove('x');
        $this->assertFalse(ClassFactory::has('x'));
        $this->assertTrue(ClassFactory::has('xxx'));

        ClassFactory::clear();
        $this->assertFalse(ClassFactory::has('x'));
        $this->assertFalse(ClassFactory::has('xxx'));
    }
}
