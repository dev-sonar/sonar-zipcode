<?php
namespace Sonar\Zipcode\Test;

use Sonar\Zipcode\EloquentModels\Zipcode;
use Sonar\Zipcode\ZipcodeImport;
use Sonar\Zipcode\PrefectureImport;
use Sonar\Zipcode\CityImport;
use Mockery;

class ZipcodeImportTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }
    public function setUp()
    {
        $this->zipcode = Mockery::mock(Zipcode::class);
        $this->city_import = Mockery::mock(CityImport::class);
        $this->prefecture_import = Mockery::mock(PrefectureImport::class);
        parent::setUp();
    }

    public function testInstance()
    {
        $zipcode = $this->zipcode;
        $prefecture_import = $this->prefecture_import;
        $city_import = $this->city_import;

        $prefecture_import->shouldReceive('setConfig');
        $city_import->shouldReceive('setConfig');

        $obj = new ZipcodeImport($zipcode,$prefecture_import,$city_import);

        $this->assertTrue($obj instanceof ZipcodeImport);
        $this->assertNull($obj->setPrefectureConfig(''));
        $this->assertNull($obj->setCityConfig(''));


    }
    public function testCsvRecord()
    {
        $zipcode = $this->zipcode;
        $zipcode->shouldReceive('findOrNew')->andReturn($zipcode);
        $zipcode->shouldReceive('setAttribute');
        $zipcode->shouldReceive('save');
        $prefecture_import = $this->prefecture_import;
        $city_import = $this->city_import;

        $prefecture_import->shouldReceive('csvRecord');
        $city_import->shouldReceive('csvRecord');


        $obj = new ZipcodeImport($zipcode,$prefecture_import,$city_import);
        $obj->setConfig(__DIR__ . '/../src/Console/zipcodes.yml');
        $csv = [ '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15' ];

        $this->assertNull($obj->setIsPrefecture(true));
        $this->assertNull($obj->setIsCity(true));
        $this->assertTrue($obj->csvRecord($csv));
    }
    public function testSetName()
    {
        $zipcode = $this->zipcode;
        $prefecture_import = $this->prefecture_import;
        $city_import = $this->city_import;
        $zipcode->shouldReceive('setAttribute');
        $obj = new ZipcodeImport($zipcode,$prefecture_import,$city_import);
        $data = ['123456789123456789123456789123456789123456789123456789123456789'];
        $this->assertTrue($obj->setName($zipcode,'name',$data,1));
    }
    public function testSetKana()
    {
        $zipcode = $this->zipcode;
        $prefecture_import = $this->prefecture_import;
        $city_import = $this->city_import;
        $zipcode->shouldReceive('setAttribute');
        $obj = new ZipcodeImport($zipcode,$prefecture_import,$city_import);
        $data = ['123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789'];
        $this->assertTrue($obj->setKana($zipcode,'kana',$data,1));
    }
}

