<?php
/**
 * Created by PhpStorm.
 * User: salman
 * Date: 01/06/2020
 * Time: 1:34 PM
 */

namespace Salman\AutoJWT;

use Illuminate\Support\ServiceProvider;
use Salman\AutoJWT\Commands\InstallJWT;

class AutoJWTServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->publishStubs();
    }

    protected function publishStubs()
    {
        $this->loadViewsFrom(__DIR__.'/resources/stubs', 'AutoJWT');

        $this->publishes([
            __DIR__.'/resources/stubs' => resource_path('vendor/salmanzafar/AutoJWT/stubs'),
        ]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->commands([
            InstallJWT::class,
        ]);
    }

}
