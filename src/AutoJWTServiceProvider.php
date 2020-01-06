<?php
/**
 * Created by PhpStorm.
 * User: salman
 * Date: 2/22/19
 * Time: 1:34 PM
 */

namespace Salman\AutoJWT;

use Illuminate\Support\ServiceProvider;

class AutoJWTServiceProvider extends ServiceProvider
{

    public function boot()
    {

    }

    public function register()
    {
      /*  $this->app->singleton('AutoJWT',function (){

            return new AutoJWT();
        });*/
    }

    /**
     * @return array
     */
    public function provides()
    {
        return ['AutoJWT'];
    }
}
