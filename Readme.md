# laravel-jwt-auto-installer

A Laravel Library that let's you add tymon jwt auth library to your project easily

## What this was required?
The people who uses tymon/jwt-auth knows that every time they installs package they need to manually create AuthController and then copy and paste the entire code their and same things for Model and Routes.
So every time when you have to do this it takes some time and being a developer we want more easy and simple way of doing thing. so the i came up with this idea of creating this and hopefully it will help you.

## Installation

Use the package manager [composer](https://packagist.org/packages/salmanzafar/laravel-jwt-auto-installer) to install laravel-jwt-auto-installer.

```bash
composer require salmanzafar/laravel-jwt-auto-installer
```
## Enable the package (Optional)
This package implements Laravel auto-discovery feature. After you install it the package provider and facade are added automatically for laravel >= 5.5.

## Configuration
Publish the configuration file

This step is required
```bash
php artisan vendor:publish --provider="Salman\AutoJWT\AutoJWTServiceProvider"
```

## Usage

```bash
php artisan jwt:init

Controller Model and Routes and Jwt Secret published.Thanks
```
### That's it now it'll publish every thing you want e.g Controller Model(with functions jwt) and api routes for JWT

### AuthController.php:

```php
<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request)
    {
        $this->validate($request, [
          "name" => "required|string|min:4",
          "email" => "required|email",
          "password" => "required|min:8|max:20|confirmed"
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response([
            'data' => 'Thank you.Your account has been created'
        ],Response::HTTP_CREATED);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
```

### User.php

```php
<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

      /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'name', 'email', 'password',
        ];

        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden = [
            'password', 'remember_token',
        ];

        /**
         * The attributes that should be cast to native types.
         *
         * @var array
         */
        protected $casts = [
            'email_verified_at' => 'datetime',
        ];


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
```

### api.php
```php
Route::group(['prefix' => 'user'], function () {
            Route::post('register', 'AuthController@register');
            Route::post('login',  'AuthController@login');
            Route::group(['middleware' => ['auth:api']], function () {
                Route::post('refresh', 'AuthController@refresh');
                Route::post('me', 'AuthController@me');
                Route::post('logout', 'AuthController@logout');
            });
});
```
## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

### Tested on php 7.3 & 7.4 and laravel 6^

## License
[MIT](https://choosealicense.com/licenses/mit/)
