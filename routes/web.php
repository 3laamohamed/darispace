<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('clear-cache',function(){
    \Artisan::call('optimize:clear');
});


Route::get('states/{id}/getCities',function($id){
    $cities = \DB::table('cities')->where('state_id',$id)->where('is_real_estate',1)->get();
    return response()->json($cities);
});

