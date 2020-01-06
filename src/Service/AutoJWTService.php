<?php
namespace Salman\AutoJWT\Service;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class AutoJWTService
{
    public static function makeThisHappen()
    {
        self::publishController();
        self::publishModel();
        self::publishRoutes();
//        self::runCommand();
    }

    private static function runCommand()
    {
        Artisan::call('jwt-secret');
    }

    private static function publishController()
    {
        $filePath = "/Http/Controllers/AuthController.php";

        $checkFile = app_path($filePath);

        $file = self::GetStubs('Controller');

        if (File::exists($checkFile))
            File::delete($checkFile);

        file_put_contents(app_path($filePath), $file);

    }

    private static function publishModel()
    {
        $checkFile = app_path('User.php');
        $file = self::GetStubs('Model');

        if (File::exists($checkFile))
            File::delete($checkFile);

        file_put_contents(app_path("User.php"), $file);
    }

    private static function publishRoutes()
    {
        $filePath  = base_path('routes/api.php');
        $routesToAppend =  self::getRoutes();

        File::append($filePath, $routesToAppend);

    }


    private static function getRoutes()
    {
        $routes  = "Route::group(['prefix' => 'user'], function () {".PHP_EOL;
        $routes .= "Route::post('register', 'AuthController@register');".PHP_EOL;
        $routes .= "Route::post('login',  'AuthController@login');".PHP_EOL;
        $routes .= "Route::group(['middleware' => ['auth:api']], function () {".PHP_EOL;
        $routes .= "Route::post('refresh', 'AuthController@refresh');".PHP_EOL;
        $routes .= "Route::post('me', 'AuthController@me');".PHP_EOL;
        $routes .= "Route::post('logout', 'AuthController@logout');".PHP_EOL;
        $routes .= "};".PHP_EOL;
        $routes .= "};".PHP_EOL;

        return $routes;
    }

    private static function GetStubs($type)
    {
        return file_get_contents(resource_path("vendor/salmanzafar/AutoJWT/stubs/$type.stub"));
    }
}
