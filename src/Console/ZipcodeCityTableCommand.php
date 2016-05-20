<?php

namespace Sonar\Zipcode\Console;

use Illuminate\Database\Console\Migrations\BaseCommand as Command;
use Illuminate\Database\Migrations\MigrationCreator;
use Illuminate\Foundation\Composer;
use Illuminate\Filesystem\Filesystem;

class ZipcodeCityTableCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'zipcode:city_table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a migration for the city database table';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * @var \Illuminate\Foundation\Composer
     */
    protected $composer;

    /**
     * @var \Illuminate\Database\Migrations\MigrationCreator
     */
    protected $creator;


    /**
     * Create a new session table command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @param  \Illuminate\Foundation\Composer  $composer
     * @param  \Illuminate\Database\Migrations\MigrationCreator $creator
     */
    public function __construct(Filesystem $files, Composer $composer,MigrationCreator $creator)
    {
        parent::__construct();

        $this->files = $files;
        $this->composer = $composer;
        $this->creator = $creator;
    }

    /**
     * Execute the console command.
     *
     */
    public function fire()
    {
        $fullPath = $this->createBaseMigration();

        $this->files->put($fullPath, $this->files->get(__DIR__.'/stubs/cities.stub'));

        $this->composer->dumpAutoloads();
    }

    /**
     * Create a base migration file for the session.
     *
     * @return string
     */
    protected function createBaseMigration()
    {
        $name = 'create_cities_table';

        $path = $this->getMigrationPath();

        return $this->creator->create($name, $path);
    }
}
