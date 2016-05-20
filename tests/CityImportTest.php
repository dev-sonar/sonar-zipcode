<?php
namespace Sonar\Zipcode\Test;

use Sonar\Zipcode\EloquentModels\City;
use Sonar\Zipcode\CityImport;
use Mockery;

class CityImportTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }
    public function setUp()
    {
        $this->city = Mockery::mock(City::class);
        parent::setUp();
    }

    public function testCsvRecord()
    {
        $city = $this->city;
        $city->shouldReceive('findOrNew')->andReturn($city);
        $city->shouldReceive('setAttribute');
        $city->shouldReceive('save');


        $obj = new CityImport($city);
        $obj->setConfig(__DIR__ . '/../src/Console/cities.yml');
        $csv = [ '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15' ];

        $this->assertTrue($obj->csvRecord($csv));
    }
    public function testSetName()
    {
        $city = $this->city;
        $city->shouldReceive('setAttribute');
        $obj = new CityImport($city);
        $data = ['123456789123456789123456789123456789123456789123456789123456789'];
        $this->assertTrue($obj->setName($city,'name',$data,1));
    }
    public function testSetKana()
    {
        $city = $this->city;
        $city->shouldReceive('setAttribute');
        $obj = new CityImport($city);
        $data = ['123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789'];
        $this->assertTrue($obj->setKana($city,'kana',$data,1));
    }
}
