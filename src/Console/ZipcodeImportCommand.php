<?php

namespace Sonar\Zipcode\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Chumper\Zipper\Zipper;
use Ixudra\Curl\Builder as Curl;

use Sonar\Zipcode\ZipcodeImport;
use Symfony\Component\Console\Input\InputOption;


use Sonar\Zipcode\ZipcodeTransfer;

class ZipcodeImportCommand extends Command
{
    const URL = 'http://www.post.japanpost.jp/zipcode/dl/kogaki/zip/ken_all.zip';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'zipcode:import {--add-prefecture : add import prefecture table.} {--add-city : add import city table.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'import zipcode table from csv data';

    protected $import;
    protected $transfer;

    private $zipper;
    private $curl;
    private $file;

    public function __construct(ZipcodeImport $import, ZipcodeTransfer $transfer, Zipper $zipper, Curl $curl, Filesystem $file)
    {
        parent::__construct();

        $this->import = $import;
        $this->transfer = $transfer;
        $this->zipper = $zipper;
        $this->curl = $curl;
        $this->file = $file;
    }

    public function fire()
    {
        $path = 'app/sonar_zipcode';

        $data = $this->curl->to(self::URL)->get();
        $this->file->put(storage_path($path . '/ken_all.zip'), $data);

        $this->extractZip(
            str_replace(base_path() . '/', '', storage_path( $path . '/ken_all.zip')),
            str_replace(base_path() . '/', '', storage_path($path))
        );

        $this->file->put(
            storage_path($path . '/ken_all.csv.utf8'),
            mb_convert_encoding($this->file->get(storage_path($path . '/KEN_ALL.CSV')), 'utf8', 'cp932')
        );

        $this->transfer->csvRead(storage_path($path . '/ken_all.csv.utf8'));
        $this->file->put(storage_path($path . '/ken_all.csv.new'), $this->transfer->getData());

        $config_file = __DIR__ . '/zipcodes.yml';
        $this->import->setConfig($config_file);

        $this->checkAddPrefecture();
        $this->checkAddCity();

        $this->import->csvRead(storage_path($path . '/ken_all.csv.new'));
    }

    public function extractZip($zip_file,$extract_path)
    {
        $zip = $this->zipper->make($zip_file);
        $zip->extractTo($extract_path . "/");
        $zip->close();
    }

    protected function checkAddPrefecture()
    {
        if ( $this->option('add-prefecture') ) {
            $prefecture_config_file = __DIR__ . '/prefectures.yml';
            $this->import->setPrefectureConfig($prefecture_config_file);
            $this->import->setIsPrefecture(true);
        }
    }
    protected function checkAddCity()
    {
        if ( $this->option('add-city') ) {
            $city_config_file = __DIR__ . '/cities.yml';
            $this->import->setCityConfig($city_config_file);
            $this->import->setIsCity(true);
        }
    }
}
