<?php

namespace Generic\Entity;

use PHPUnit\Framework\TestCase;

class MockEntity extends Entity
{
    public $x;
    protected $y;
    private $z;
    static $foo; // This one should always be ignored.
}

class MockUserEntity extends Entity
{
    public $firstName;
    protected $lastName;
    private $email;

    public static $settersCounter = 0; 
    public static $gettersCounter = 0;
    
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        self::$settersCounter++;
        return $this;
    }
    
    public function getFirstName()
    {
        self::$gettersCounter++;
        return $this->firstName;
    }
    
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        self::$settersCounter++;
        return $this;
    }
    
    public function getLastName()
    {
        self::$gettersCounter++;
        return $this->lastName;
    }
    
    public function setEmail($email)
    {
        $this->email = $email;
        self::$settersCounter++;
        return $this;
    }
    
    public function getEmail()
    {
        self::$gettersCounter++;
        return $this->email;
    }
}

class EntityTest extends TestCase
{
    public function testEmptySmartObjectToArray()
    {
        $object = new Entity();
        $this->assertEquals(0, count($object->toArray()));
    }
    
    public function testEmptyMockSmartObjectToArray()
    {
        $object = new MockEntity();
        $array = $object->toArray();
        $this->assertEquals(3, count($array));
        $this->assertNull($array['x']);
        $this->assertNull($array['y']);
        $this->assertNull($array['z']);
    }
    
    public function testPopulateOnSmartObject()
    {
        $object = new Entity(['abc' => 123]);
        $this->assertEquals(0, count($object->toArray()));
    }
    
    public function testPopulateOnMockSmartObject()
    {
        $object = new MockEntity([
            'x' => 123,
            'y' => 456,
            'z' => 789
        ]);
        $array = $object->toArray();
        $this->assertEquals(3, count($array));
    }
    
    public function testMockUserSmartObject()
    {
        $user = new MockUserEntity([
            'firstName' => 'Test',
            'lastName' => 'Testowski',
            'email' => 'test.testowski@domain.tld'
        ]);
        $array = $user->toArray();
        $this->assertEquals(3, MockUserEntity::$settersCounter);
        $this->assertEquals(3, MockUserEntity::$gettersCounter);
        $this->assertEquals(3, count($array));
        $this->assertEquals('Test', $array['firstName']);
        $this->assertEquals('Testowski', $array['lastName']);
        $this->assertEquals('test.testowski@domain.tld', $array['email']);
    }
}
