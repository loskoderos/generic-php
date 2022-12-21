<?php

namespace Tests\LosKoderos\Generic;

use PHPUnit\Framework\TestCase;
use LosKoderos\Generic\Model\Model;

class MockModel extends Model
{
    public $x;
    protected $y;
    private $z;
    static $foo; // This one should always be ignored.
}

class MockUserModel extends Model
{
    public $firstName;
    protected $lastName;
    private $email;
    protected $createdAt;

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

class MockModelLevel3 extends Model 
{
    public int $z = 0;
}

class MockModelLevel2 extends Model
{
    public int $y = 0;
    public MockModelLevel3 $nested;
}

class MockModelLevel1 extends Model
{
    public int $x = 0;
    public MockModelLevel2 $nested2;
    public MockModelLevel3 $nested3;
}

class ModelTest extends TestCase
{
    public function testEmptySmartObjectToArray()
    {
        $object = new Model();
        $this->assertEquals(0, count($object->toArray()));
    }
    
    public function testEmptyMockSmartObjectToArray()
    {
        $object = new MockModel();
        $array = $object->toArray();
        $this->assertEquals(3, count($array));
        $this->assertNull($array['x']);
        $this->assertNull($array['y']);
        $this->assertNull($array['z']);
    }
    
    public function testPopulateOnSmartObject()
    {
        $object = new Model(['abc' => 123]);
        $this->assertEquals(0, count($object->toArray()));
    }
    
    public function testPopulateOnMockSmartObject()
    {
        $object = new MockModel([
            'x' => 123,
            'y' => 456,
            'z' => 789
        ]);
        $array = $object->toArray();
        $this->assertEquals(3, count($array));
    }
    
    public function testMockUserSmartObject()
    {
        $user = new MockUserModel([
            'firstName' => 'Test',
            'lastName' => 'Testowski',
            'email' => 'test.testowski@domain.tld',
            'createdAt' => new \DateTime('2018-06-22')
        ]);
        $array = $user->toArray();
        $this->assertEquals(3, MockUserModel::$settersCounter);
        $this->assertEquals(3, MockUserModel::$gettersCounter);
        $this->assertEquals(4, count($array));
        $this->assertEquals('Test', $array['firstName']);
        $this->assertEquals('Testowski', $array['lastName']);
        $this->assertEquals('test.testowski@domain.tld', $array['email']);
        $this->assertStringStartsWith('2018-06-22T00:00:00', $array['createdAt']);
    }

    public function testPopulateOnNestedMocks()
    {
        $model = new MockModelLevel1([
            'x' => 123,
            'nested2' => [
                'y' => 456,
                'nested' => [
                    'z' => 789
                ]
            ],
            'nested3' => [
                'z' => 987
            ]
        ]);
        $this->assertEquals(123, $model->x);
        $this->assertInstanceOf(MockModelLevel2::class, $model->nested2);
        $this->assertEquals(456, $model->nested2->y);
        $this->assertInstanceOf(MockModelLevel3::class, $model->nested2->nested);
        $this->assertEquals(789, $model->nested2->nested->z);
        $this->assertInstanceOf(MockModelLevel3::class, $model->nested3);
        $this->assertEquals(987, $model->nested3->z);
    }
}
