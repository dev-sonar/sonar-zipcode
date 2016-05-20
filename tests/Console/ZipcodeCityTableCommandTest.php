<?php
namespace Sonar\Zipcode\Test\Console;

use Sonar\Zipcode\Console\ZipcodeCityTableCommand;
use Sonar\Zipcode\Test\TestCase;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Composer;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Database\Migrations\MigrationCreator;

use Mockery;

class ZipcodeCityTableCommandTest extends TestCase
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
        $this->creator = Mockery::mock(MigrationCreator::class);
    }

    public function testInstance()
    {
        $obj = new ZipcodeCityTableCommand($this->filesystem,$this->composer,$this->creator);
        $this->assertTrue($obj instanceof ZipcodeCityTableCommand);
    }

    public function testFire()
    {
        $this->filesystem->shouldReceive('get');
        $this->filesystem->shouldReceive('put');
        $this->composer->shouldReceive('dumpAutoloads');
        $this->creator->shouldReceive('create');

        $obj = new ZipcodeCityTableCommand($this->filesystem,$this->composer,$this->creator);
        $laravel = Mockery::mock(Application::class);
        $laravel->shouldReceive('databasePath')->andReturn('');
        $migration = Mockery::mock('migration');
        $migration->shouldReceive('create')->andReturn();
        $laravel->shouldReceive('offsetGet')->andReturn($migration);

        $obj->setLaravel($laravel);

        $this->assertNull($obj->fire());

    }


}
