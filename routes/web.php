<?php

use Illuminate\Support\Facades\Auth;
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


Route::get('/users/{user}', 'Auth\EditController@index')
->name('user.edit')
->middleware('auth');

Route::put('/users/{user}', 'Auth\EditController@update')
->name('user.update')
->middleware('auth');

Route::namespace('Guest')
->prefix('home')
->name("home.")
->group(function(){
    Route::get('/', 'HomeController@index');
    // Route::resource('posts',"PostsController");

});

Route::get('/admin/create', 'Admin\ApartmentsController@create')->name('home');
