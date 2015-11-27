<?php

namespace Sonar\Zipcode;

use Illuminate\Support\ServiceProvider;

class ZipcodeServiceProvider extends ServiceProvider
{
    protected $commands = [
        'Sonar\Zipcode\Console\ZipcodeTableCommand',
        'Sonar\Zipcode\Console\ZipcodeImportCommand',
    ];

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../storage/app/sonar_zipcode' => storage_path('app/sonar_zipcode'),
        ]);
        //
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);
    }

    public function provides()
    {
        return ['sonar_zipcode'];
    }
}
