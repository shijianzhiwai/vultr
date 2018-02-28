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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('auth')->get('/logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Route::get('/vultr', 'VultrController@index');

Route::prefix('api/vultr')->middleware('auth.api', 'throttle:60,1')->group(function ($route) {
    $route->get('fire_list', 'VultrController@fireList');
    $route->get('user', 'VultrController@user');
    $route->get('rule_list', 'VultrController@ruleList');
});