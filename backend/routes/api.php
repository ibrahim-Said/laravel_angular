<?php

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('requestResetPassword', 'PasswordController@sendEmail');
    Route::post('responseResetPassword', 'PasswordController@changePassword');
    Route::get('requestResetPassword', 'PasswordController@test');

});
