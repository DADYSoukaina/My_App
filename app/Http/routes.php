<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix'=>'api'], function(){
    Route::resource('famille','FamilleController');

    Route::resource('produit','produitController');

   /* Route::post('user',[
        'uses' =>'AuthController@store'
    ]);

    Route::post('user/signin',[
        'uses' =>'AuthController@signin'
    ]);*/

});