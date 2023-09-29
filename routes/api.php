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
use App\Http\Controllers\Api\Auth\VerifyAccountController;

Route::group(
    [
        'prefix' => 'v1',
    ], function(){

        Route::get('app/info', function(){
            return response()->json([
                'ios_version'=>(int)setting('android_version'),
                'android_version'=>(int)setting('android_version'),
                'force_update'=>(boolean)setting('force_update'),
                "google_play_link"=>setting('android_link'),
                "apple_store_link"=>setting('ios_link')
            ]);
        });

        Route::group(
            [
                'prefix' => 'auth',
            ], function(){

                //forgot password
                Route::post('password/forgot',  [ForgotPasswordController::class,'forgot']);
                Route::post('password/code/check', [ForgotPasswordController::class,'checkCode']);
                Route::post('password/reset', [ForgotPasswordController::class,'resetPassword']);

                Route::post('verify/send-code', [VerifyAccountController::class, 'sendCode']);
                Route::post('verify/account', [VerifyAccountController::class, 'verifyAccount']);

        });
    });
