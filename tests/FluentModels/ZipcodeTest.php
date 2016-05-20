<?php
namespace Sonar\Zipcode\Test\FluentModels;

use Sonar\Zipcode\Test\TestCase;
use Mockery;
use Sonar\Zipcode\FluentModels\Zipcode;

class ZipcodeTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }
    public function setUp()
    {
        parent::setUp();
        $this->builder = Mockery::mock('Illuminate\Database\Connection');
    }

    public function testインスタンス()
    {
        $obj = new Zipcode($this->builder);

        $this->assertTrue($obj instanceof Zipcode);
    }
    public function testgetListByCityId()
    {
        $obj = new Zipcode($this->builder);
        $this->assertTrue(is_array($obj->getListByCityId(null)));

        $this->builder->shouldReceive('select')->once()->andReturn($this->builder);
        $this->builder->shouldReceive('whereNull')->once()->andReturn($this->builder);
        $this->builder->shouldReceive('where')->once()->andReturn($this->builder);
        $this->builder->shouldReceive('orderBy')->once()->andReturn($this->builder);
        $this->builder->shouldReceive('table')->once()->andReturn($this->builder);
        $this->builder->shouldReceive('get')->once()->andReturn('1');

        $obj = new Zipcode($this->builder);
        $this->assertTrue($obj->getListByCityId(1) == '1');
    }
    public function testgetListByCode()
    {
        $obj = new Zipcode($this->builder);
        $this->assertTrue(is_array($obj->getListByCityId(null)));

        $this->builder->shouldReceive('select')->once()->andReturn($this->builder);
        $this->builder->shouldReceive('whereNull')->once()->andReturn($this->builder);
        $this->builder->shouldReceive('where')->once()->andReturn($this->builder);
        $this->builder->shouldReceive('table')->once()->andReturn($this->builder);
        $this->builder->shouldReceive('orderBy')->once()->andReturn($this->builder);
        $this->builder->shouldReceive('get')->once()->andReturn('1');

        $obj = new Zipcode($this->builder);
        $this->assertTrue($obj->getListByCode(1) == '1');

    }
}

