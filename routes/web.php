<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get( '/', function () {
    return view( 'welcome' );
} )->name( 'home' );

Route::namespace( 'Auth' )->group( function () {
    Route::get( 'login', 'Services\GoogleController@login' )->name( 'login' );
    Route::get( 'login/callback', 'Services\GoogleController@handle' );
    Route::delete( 'logout', 'LoginController@destroy' )->name( 'logout' );
} );
