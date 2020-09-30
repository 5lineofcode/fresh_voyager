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
    $view = "welcome";
    $page_title = "wow";

    $display_name_plural = "Z";
    
    return Voyager::view($view, compact(
        'page_title',
        'display_name_plural'
    ));
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::group(['prefix' => 'api'], function () {
    Route::get('/product', function () {
        return 'welcome, product';
    });
});

Route::get('example', 'Api\ExampleController@index');