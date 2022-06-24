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

Route::get('/', 'HomeController@index')->name('home');
Route::get('/webcrawl/store', 'WebcrawlerController@store')->name('webcrawl.store');
Route::get('/webcrawl/index', 'WebcrawlerController@index')->name('webcrawl.index');
Route::get('/webcrawl/show', 'WebcrawlerController@show')->name('webcrawl.show');
Route::get('/image/show', 'ImageController@show')->name('image.show');
