<?php
namespace Sonar\Zipcode\Test\Console;

use Sonar\Zipcode\Console\ZipcodeImportCommand;
use Sonar\Zipcode\Test\TestCase;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Container\Container;
use Chumper\Zipper\Zipper;
use Ixudra\Curl\Builder as Curl;

use Sonar\Zipcode\ZipcodeImport;
use Sonar\Zipcode\ZipcodeTransfer;

use Mockery;

require_once __DIR__ . "/../helpers.php";

class ZipcodeImportCommandTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function setUp()
    {
        parent::setUp();
        $this->import = Mockery::mock(ZipcodeImport::class);
        $this->transfer = Mockery::mock(ZipcodeTransfer::class);
        $this->zipper = Mockery::mock(Zipper::class);
        $this->curl = Mockery::mock(Curl::class);
        $this->file = Mockery::mock(Filesystem::class);
    }

    public function testInstance()
    {
        $obj = new ZipcodeImportCommand($this->import,$this->transfer,$this->zipper,$this->curl,$this->file);
        $this->assertTrue($obj instanceof ZipcodeImportCommand);
    }

    public function testFire()
    {
        $this->file->shouldReceive('isDirectory')->andReturn(true);
        $this->file->shouldReceive('put');
        $this->file->shouldReceive('get');
        $this->curl->shouldReceive('to')->andReturn($this->curl);
        $this->curl->shouldReceive('get')->andReturn('');
        $this->zipper->shouldReceive('make')->andReturn($this->zipper);
        $this->zipper->shouldReceive('extractTo');
        $this->zipper->shouldReceive('close');

        $this->transfer->shouldReceive('csvRead');
        $this->transfer->shouldReceive('getData');

        $this->import->shouldReceive('setConfig');
        $this->import->shouldReceive('setPrefectureConfig');
        $this->import->shouldReceive('setIsPrefecture');
        $this->import->shouldReceive('setCityConfig');
        $this->import->shouldReceive('setIsCity');
        $this->import->shouldReceive('csvRead');

        $obj = new ZipcodeImportCommand($this->import,$this->transfer,$this->zipper,$this->curl,$this->file);

        $input = Mockery::mock(\Symfony\Component\Console\Input\InputInterface::class);
        $output = Mockery::mock(\Symfony\Component\Console\Output\OutputInterface::class,\Symfony\Component\Console\Formatter\OutputFormatterInterface::class);
        $output->shouldReceive('getVerbosity')->andReturn($output);;
        $output->shouldReceive('getFormatter')->andReturn($output);
        $output->shouldReceive('setDecorated')->andReturn($output);

        $input->shouldReceive('bind')->andReturn($input);
        $input->shouldReceive('isInteractive')->andReturn($input);
        $input->shouldReceive('hasArgument')->andReturn($input);
        $input->shouldReceive('getArgument')->andReturn($input);
        $input->shouldReceive('validate')->andReturn(true);
        $input->shouldReceive('getOption')->andReturn(true);

        $laravel = Mockery::mock(\Illuminate\Contracts\Foundation\Application::class);
        $obj->setLaravel(new Container());
        //$obj->setApplication(app(\Symfony\Component\Console\Application::class));


        $this->assertEquals($obj->run($input,$output),0);

    }


}
