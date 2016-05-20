<?php
namespace Sonar\Zipcode\Test\EloquentModels;
use Sonar\Zipcode\Test\TestCase;

use Sonar\Zipcode\EloquentModels\Zipcode;

class ZipcodeTest extends TestCase
{
    public function testInstance()
    {
        $obj = new Zipcode;
        $this->assertTrue($obj instanceof Zipcode);
    }
}

