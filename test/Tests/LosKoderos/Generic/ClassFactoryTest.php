<?php

namespace Tests\LosKoderos\Generic;

use PHPUnit\Framework\TestCase;
use LosKoderos\Generic\ClassFactory\ClassFactory;

use function LosKoderos\Generic\ClassFactory\cf_clear;
use function LosKoderos\Generic\ClassFactory\cf_get;
use function LosKoderos\Generic\ClassFactory\cf_has;
use function LosKoderos\Generic\ClassFactory\cf_new;
use function LosKoderos\Generic\ClassFactory\cf_override;
use function LosKoderos\Generic\ClassFactory\cf_remove;
use function LosKoderos\Generic\ClassFactory\cf_set;

class ClassFactoryTest extends TestCase
{
    public function testClassFactoryObject()
    {
        $cf = ClassFactory::getInstance();
        $this->assertInstanceOf(ClassFactory::class, $cf);
        
        $x = $cf->clear()->override(['x' => 'y'])->get('x');
        $this->assertEquals('y', $x);
        $this->assertTrue($cf->has('x'));
        $this->assertFalse($cf->has('y'));

        $this->assertFalse($cf->has(\stdClass::class));
        $o = $cf->create(\stdClass::class);
        $this->assertInstanceOf(\stdClass::class, $o);

        $cf->set('xxx', \stdClass::class);
        $this->assertTrue($cf->has('xxx'));
        $o = $cf->create('xxx');
        $this->assertInstanceOf(\stdClass::class, $o);

        $cf->remove('x');
        $this->assertFalse($cf->has('x'));
        $this->assertTrue($cf->has('xxx'));

        $cf->clear();
        $this->assertFalse($cf->has('x'));
        $this->assertFalse($cf->has('xxx'));
    }

    public function testHelpers()
    {
        cf_clear();
        cf_override(['x' =>'y']);
        $this->assertTrue(cf_has('x'));
        $this->assertEquals('y', cf_get('x'));
        $this->assertFalse(cf_has('y'));

        $this->assertFalse(cf_has(\stdClass::class));
        $o = cf_new(\stdClass::class);
        $this->assertInstanceOf(\stdClass::class, $o);

        cf_set('xxx', \stdClass::class);
        $this->assertTrue(cf_has('xxx'));
        $o = cf_new('xxx');
        $this->assertInstanceOf(\stdClass::class, $o);

        cf_remove('x');
        $this->assertFalse(cf_has('x'));
        $this->assertTrue(cf_has('xxx'));

        cf_clear();
        $this->assertFalse(cf_has('x'));
        $this->assertFalse(cf_has('xxx'));
    }
}
