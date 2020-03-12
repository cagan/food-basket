<?php
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
        'namespace' => 'Auth',
    ],
    function () {
        Route::post('login', 'LoginController@login');
        Route::post('register', 'RegisterController@register');
        Route::post('register/activate/{token}', 'RegisterController@activateUser');

        Route::group(
            [
                'middleware' => 'auth:api',
            ],
            function () {
                Route::get('user', 'UserController@getUser');

                Route::get('logout', 'LogoutController@logout');
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
        Route::get('admin/set/{id}', 'UserController@makeUserAdmin');
    }
);


