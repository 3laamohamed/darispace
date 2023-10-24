<?php

use Botble\Api\Http\Controllers\PublicController;
use Botble\Api\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Artisan;

Route::group([
    'prefix' => 'api/v1',
    'namespace' => 'Botble\Api\Http\Controllers',
    'middleware' => ['api'],
], function () {

    Route::post('register', 'AuthenticationController@register');
    Route::post('login', 'AuthenticationController@login');

    Route::get('indexR', 'AuthenticationController@indexR');

    Route::post('password/forgot', 'ForgotPasswordController@sendResetLinkEmail');

    Route::post('resend-verify-account-email', 'VerificationController@resend');

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::get('logout', 'AuthenticationController@logout');
        Route::get('deleteAccount', 'AuthenticationController@deleteAccount');
        Route::get('me', 'ProfileController@getProfile');
        Route::post('me', 'ProfileController@updateProfile');
        Route::post('update/avatar', 'ProfileController@updateAvatar');
        Route::put('update/password', 'ProfileController@updatePassword');

        Route::post('review/{slug}', [ReviewController::class, 'store']);


    });
    Route::post('contact', [PublicController::class, 'postSendContact']);

    Route::get('/index', 'ApiController@indexR');
    Route::get('/test', 'ApiController@test');

    //projects
    Route::get('projects','ProjectController@filterProjects');
    Route::get('projects/filterSelections','ProjectController@filterSelections');
    Route::get('project/{id}','ProjectController@getProject');
    Route::get('projects/filter','ProjectController@filterProjects');
    Route::get('projects/getCities','ProjectController@getCities');


    //investors
    Route::get('investors','InvestorController@filterInvestors');
    Route::get('investors/filterSelections','InvestorController@filterSelections');
    Route::get('investor/{id}','InvestorController@getInvestor');
    Route::get('investors/filter','InvestorController@filterInvestors');

    //properties
    Route::get('properties','PropertyController@filterProperties');
    Route::post('properties/store','PropertyController@store')->middleware('auth:sanctum');
    Route::post('properties/update/{id}','PropertyController@update')->middleware('auth:sanctum');
    Route::delete('properties/delete/{id}','PropertyController@destroy')->middleware('auth:sanctum');
    Route::get('properties/facilities_features','PropertyController@facilities_features');
    Route::get('properties/getUserProperties','PropertyController@getUserProperties')->middleware('auth:sanctum');
    Route::get('properties/filterSelections','PropertyController@filterSelections');
    Route::get('properties/categories','PropertyController@categories');
    Route::get('properties/featuredProperties','PropertyController@featuredProperties');
    Route::get('properties/recentProperties','PropertyController@recentProperties');
    Route::get('property/{id}','PropertyController@getProperty');
    Route::get('properties/filter','PropertyController@filterProperties');
    Route::get('properties/getStatuses','PropertyController@getStatuses');

    //countries
    Route::get('getCountries','CountryController@getCountries');
    Route::get('getCities','CountryController@getCities');
    Route::get('getStates','CountryController@getStates');
    Route::get('getCurrencies','CountryController@getCurrencies');


    //about
    Route::get('about','PublicController@about');

    //packages
    Route::get('packages','PackageController@getPackages')->middleware('auth:sanctum');
    Route::post('packages/subscribe','PackageController@ajaxSubscribePackage')->middleware('auth:sanctum');
        
});
