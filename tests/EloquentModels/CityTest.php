<?php
namespace Sonar\Zipcode\Test\EloquentModels;
use Sonar\Zipcode\Test\TestCase;

use Sonar\Zipcode\EloquentModels\City;

class CityTest extends TestCase
{
    public function testInstance()
    {
        $obj = new City;
        $this->assertTrue($obj instanceof City);
    }
}

