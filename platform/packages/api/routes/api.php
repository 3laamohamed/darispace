<?php

use Botble\Api\Http\Controllers\ReviewController;

Route::group([
    'prefix' => 'api/v1',
    'namespace' => 'Botble\Api\Http\Controllers',
    'middleware' => ['api'],
], function () {
    Route::post('register', 'AuthenticationController@register');
    Route::post('login', 'AuthenticationController@login');

    Route::post('password/forgot', 'ForgotPasswordController@sendResetLinkEmail');

    Route::post('resend-verify-account-email', 'VerificationController@resend');

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::get('logout', 'AuthenticationController@logout');
        Route::get('me', 'ProfileController@getProfile');
        Route::put('me', 'ProfileController@updateProfile');
        Route::post('update/avatar', 'ProfileController@updateAvatar');
        Route::put('update/password', 'ProfileController@updatePassword');

        Route::post('review/{slug}', [ReviewController::class, 'store']);

    });

    Route::get('/index', 'ApiController@indexR');
    Route::get('/test', 'ApiController@test');

    //projects
    Route::get('projects','ProjectController@getProjects');
    Route::get('project/{id}','ProjectController@getProject');
    Route::get('projects/filter','ProjectController@filterProjects');

    //properties
    Route::get('properties','PropertyController@getProperties');
    Route::get('property/{id}','PropertyController@getProperty');
    Route::get('properties/filter','PropertyController@filterProperties');
});
