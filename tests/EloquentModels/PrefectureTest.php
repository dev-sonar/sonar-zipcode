<?php
namespace Sonar\Zipcode\Test\EloquentModels;
use Sonar\Zipcode\Test\TestCase;

use Sonar\Zipcode\EloquentModels\Prefecture;

class PrefectureTest extends TestCase
{
    public function testInstance()
    {
        $obj = new Prefecture;
        $this->assertTrue($obj instanceof Prefecture);
    }
}

