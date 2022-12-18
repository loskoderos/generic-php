<?php

namespace Tests\Koderos\Generic;

use PHPUnit\Framework\TestCase;
use Koderos\Generic\Utils\RandomUtils;

class RandomUtilsTest extends TestCase
{
  public function testRandomString()
  {
      $x = RandomUtils::randomString(16);
      $this->assertEquals(16, strlen($x));
  }
}
