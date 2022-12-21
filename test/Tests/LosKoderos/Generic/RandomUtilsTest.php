<?php

namespace Tests\LosKoderos\Generic;

use PHPUnit\Framework\TestCase;
use LosKoderos\Generic\Utils\RandomUtils;

class RandomUtilsTest extends TestCase
{
  public function testRandomString()
  {
      $x = RandomUtils::randomString(16);
      $this->assertEquals(16, strlen($x));
  }

  public function testRandomStringWithStringDict()
  {
    $x = RandomUtils::randomString(16, 'abcd');
    $this->assertEquals(16, strlen($x));
  }

  public function testRandomStringWithArrayDict()
  {
    $x = RandomUtils::randomString(9, ['abc', 'def', 'ghi']);
    $this->assertEquals(9 * 3, strlen($x));
  }
}
