<?php

namespace Sonar\Zipcode\Console;
namespace Sonar\Zipcode\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Chumper\Zipper\Zipper;
use Ixudra\Curl\Builder as Curl;

use Sonar\Zipcode\ZipcodeImport;
use Sonar\Zipcode\ZipcodeTransfer;

class ZipcodeImportCommand extends Command
{
    const URL = 'http://www.post.japanpost.jp/zipcode/dl/kogaki/zip/ken_all.zip';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'zipcode:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'import zipcode table from csv data';

    protected $import;
    protected $trasfer;

    public function __construct(ZipcodeImport $import,ZipcodeTransfer $transfer,Zipper $zipper,Curl $curl,FileSystem $file)
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
        $this->file->put(storage_path($path . '/ken_all.zip'),$data);
        $zip_file = str_replace(base_path() . '/' ,'',storage_path( $path . '/ken_all.zip'));
        $extract_path = str_replace(base_path() . '/' ,'',storage_path($path));

        $zip = $this->zipper->make($zip_file);
        $zip->extractTo($extract_path . "/");
        $zip->close();

        $this->file->put(
            storage_path($path . '/ken_all.csv.utf8'),
            mb_convert_encoding($this->file->get(storage_path($path . '/KEN_ALL.CSV')),'utf8','cp932')
        );

        $this->transfer->csvRead(storage_path($path . '/ken_all.csv.utf8'));
        $this->file->put(storage_path($path . '/ken_all.csv.new'),$this->transfer->getData());

        $config_file = __DIR__ . '/zipcodes.yml';
        $this->import->setConfig($config_file);

        $this->import->csvRead(storage_path($path . '/ken_all.csv.new'));
    }
}
