<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
 * Pizza Api Resource Routes
 */

Route::apiResource('pizzas', 'PizzaController')->middleware('auth:api')->except('index');

Route::get('pizzas', 'PizzaController@index');

/*
 * Order Api Resource Routes
 */
Route::apiResource('orders', 'OrderController')->middleware('auth:api');

Route::group(
/**
 * Authentication Routes
 */
    [
        'prefix' => 'auth',
    ],
    function () {
        Route::post('login', 'AuthController@login');

        Route::post('signup', 'AuthController@signup');

        Route::get('signup/activate/{token}', 'AuthController@signupActivate');

        Route::group(
            [
                'middleware' => 'auth:api',
            ],
            function () {
                Route::get('logout', 'AuthController@logout');

                Route::get('user', 'AuthController@user');
            }
        );
    }
);

Route::group(
/**
 * Password Routes
 */
    [
        'middleware' => 'api',
        'prefix' => 'password',
    ],
    function () {
        Route::post('create', 'PasswordResetController@create');

        Route::get('find/{token}', 'PasswordResetController@find');

        Route::post('reset', 'PasswordResetController@reset');
    }
);

Route::group(
/**
 * Admin Routes
 */
    [
        'middleware' => 'auth:api',
        'prefix' => 'user',
    ],
    function () {
        Route::get('setadmin/{id}', 'UserController@makeUserAsAdmin');
    }
);
