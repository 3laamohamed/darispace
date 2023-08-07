<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

use App\Http\Controllers\Api\Auth\ForgotPasswordController;

Route::group(
    [
        'prefix' => 'v1',
    ], function(){

        Route::group(
            [
                'prefix' => 'auth',
            ], function(){

                //forgot password
                Route::post('password/forgot',  [ForgotPasswordController::class,'forgot']);
                Route::post('password/code/check', [ForgotPasswordController::class,'checkCode']);
                Route::post('password/reset', [ForgotPasswordController::class,'resetPassword']);
        });
    });
