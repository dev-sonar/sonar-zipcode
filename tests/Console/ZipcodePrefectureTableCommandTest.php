<?php
namespace Sonar\Zipcode\Test\Console;

use Sonar\Zipcode\Console\ZipcodePrefectureTableCommand;
use Sonar\Zipcode\Test\TestCase;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Composer;
use Illuminate\Filesystem\Filesystem;

use Mockery;

class ZipcodePrefectureTableCommandTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function setUp()
    {
        parent::setUp();
        $this->composer = Mockery::mock(Composer::class);
        $this->filesystem = Mockery::mock(Filesystem::class);
    }

    public function testInstance()
    {
        $obj = new ZipcodePrefectureTableCommand($this->filesystem,$this->composer);
        $this->assertTrue($obj instanceof ZipcodePrefectureTableCommand);
    }

    public function testFire()
    {
        $this->filesystem->shouldReceive('get');
        $this->filesystem->shouldReceive('put');
        $this->composer->shouldReceive('dumpAutoloads');

        $obj = new ZipcodePrefectureTableCommand($this->filesystem,$this->composer);
        $laravel = Mockery::mock(Application::class);
        $laravel->shouldReceive('databasePath')->andReturn('');
        $migration = Mockery::mock('migration');
        $migration->shouldReceive('create')->andReturn();
        $laravel->shouldReceive('offsetGet')->andReturn($migration);

        $obj->setLaravel($laravel);

        $this->assertNull($obj->fire());

    }


}