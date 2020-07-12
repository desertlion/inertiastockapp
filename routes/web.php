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

Route::inertia('/', 'auth/login')->name('index');

Route::group(['middleware' => 'auth'], function () {
    Route::post('users', 'UserController@store')->name('user.store');
    Route::inertia('home', 'home')->name('home');
    Route::get('pegawai', 'UserController@index')->name('pegawai');
    Route::inertia('pegawai/form', 'pegawai-form')->name('pegawai.form');
    Route::get('pegawai/edit/{id}', 'UserController@edit')->name('pegawai.edit');

    Route::resource('products', 'ProductsController');
});

Auth::routes();
