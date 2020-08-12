<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/gift/cancel', 'GiftController@cancel');
Route::get('/gift/convert', 'GiftController@convert');
Route::get('/gift/action', 'GiftController@action');
Route::resource('gift', 'GiftController');

Route::get('/home', 'HomeController@index')->name('home');
