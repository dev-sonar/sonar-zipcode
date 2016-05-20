<?php
namespace Sonar\Zipcode\Test;

use Sonar\Zipcode\EloquentModels\Prefecture;
use Sonar\Zipcode\PrefectureImport;
use Mockery;

class PrefectureImportTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }
    public function setUp()
    {
        $this->prefecture = Mockery::mock(Prefecture::class);
        parent::setUp();
    }

    public function testCsvRecord()
    {
        $prefecture = $this->prefecture;
        $prefecture->shouldReceive('findOrNew')->andReturn($prefecture);
        $prefecture->shouldReceive('setAttribute');
        $prefecture->shouldReceive('save');


        $obj = new PrefectureImport($prefecture);
        $obj->setConfig(__DIR__ . '/../src/Console/prefectures.yml');
        $csv = [ '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15' ];

        $this->assertTrue($obj->csvRecord($csv));
    }
    public function testSetName()
    {
        $prefecture = $this->prefecture;
        $prefecture->shouldReceive('setAttribute');
        $obj = new PrefectureImport($prefecture);
        $data = ['123456789123456789123456789123456789123456789123456789123456789'];
        $this->assertTrue($obj->setName($prefecture,'name',$data,1));
    }
    public function testSetKana()
    {
        $prefecture = $this->prefecture;
        $prefecture->shouldReceive('setAttribute');
        $obj = new PrefectureImport($prefecture);
        $data = ['123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789'];
        $this->assertTrue($obj->setKana($prefecture,'kana',$data,1));
    }
}
