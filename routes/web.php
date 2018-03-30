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

Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('auth')->get('/logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Route::get('/vultr', 'VultrController@index');

Route::prefix('api/vultr')->middleware('auth.api', 'throttle:600,1')->group(function ($route) {
    $route->get('fire_list', 'VultrController@fireList');
    $route->get('user', 'VultrController@user');
    $route->get('rule_list', 'VultrController@ruleList');
    $route->post('rule_delete', 'VultrController@ruleDelete');
    $route->apiResource('ips', 'IpController');
});
Route::get('my_ip','IpController@myIp');

Route::get('/doc/{path}', 'DocController@index')->where('path', '.*')->middleware('auth');
Route::get('/doc', 'DocController@index')->middleware('auth');


/*
Route::group([
    'as' => 'admin.', // the trailing dot makes me think this is unintended
    'prefix' => 'admin'
], function () {
    Route::resource('users', 'UserController');
});

Route::resource('users', 'UserController');

//查看当前定义的所有路由
php artisan route:list
+--------+-----------+-------------------------+---------------------+---------------------------------------------+------------+
| Domain | Method    | URI                     | Name                | Action                                      | Middleware |
+--------+-----------+-------------------------+---------------------+---------------------------------------------+------------+
|        | GET|HEAD  | admin/users             | admin.users.index   | App\Http\Controllers\UserController@index   | web        |
|        | POST      | admin/users             | admin.users.store   | App\Http\Controllers\UserController@store   | web        |
|        | GET|HEAD  | admin/users/create      | admin.users.create  | App\Http\Controllers\UserController@create  | web        |
|        | GET|HEAD  | admin/users/{user}      | admin.users.show    | App\Http\Controllers\UserController@show    | web        |
|        | PUT|PATCH | admin/users/{user}      | admin.users.update  | App\Http\Controllers\UserController@update  | web        |
|        | DELETE    | admin/users/{user}      | admin.users.destroy | App\Http\Controllers\UserController@destroy | web        |
|        | GET|HEAD  | admin/users/{user}/edit | admin.users.edit    | App\Http\Controllers\UserController@edit    | web        |
|        | GET|HEAD  | users                   | users.index         | App\Http\Controllers\UserController@index   | web        |
|        | POST      | users                   | users.store         | App\Http\Controllers\UserController@store   | web        |
|        | GET|HEAD  | users/create            | users.create        | App\Http\Controllers\UserController@create  | web        |
|        | GET|HEAD  | users/{user}            | users.show          | App\Http\Controllers\UserController@show    | web        |
|        | PUT|PATCH | users/{user}            | users.update        | App\Http\Controllers\UserController@update  | web        |
|        | DELETE    | users/{user}            | users.destroy       | App\Http\Controllers\UserController@destroy | web        |
|        | GET|HEAD  | users/{user}/edit       | users.edit          | App\Http\Controllers\UserController@edit    | web        |
+--------+-----------+-------------------------+---------------------+---------------------------------------------+------------+
*/