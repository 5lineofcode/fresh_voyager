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

Route::group(['prefix' => 'crud'], function () {
    Route::get('/definition',function(){
        $controller = App::make('\App\Http\Controllers\Api\CrudGeneratorController');
        return $controller->callAction('definition',[]);
    });
});

Route::group(['prefix' => 'api'], function () {
    // Route::get('/product', 'Api\ProductController@index');
    // Route::get('/product', 'Api\CrudGeneratorController@index');

    Route::get('/{endpoint}',function($endpoint){
        $controller = App::make('\App\Http\Controllers\Api\CrudGeneratorController');
        return $controller->callAction('index', [$endpoint]);
    });

    Route::get('/{endpoint}/{id}',function($endpoint,$id){
        $controller = App::make('\App\Http\Controllers\Api\CrudGeneratorController');
        return $controller->callAction('single_item', [$endpoint, $id]);
    });

    Route::post('/{endpoint}',function($endpoint){
        $postdata = Request::all();
        $controller = App::make('\App\Http\Controllers\Api\CrudGeneratorController');
        return $controller->callAction('create', [$endpoint, $postdata] );
    });

    Route::put('/{endpoint}/{id}',function($endpoint,$id){
        $postdata = Request::all();
        $controller = App::make('\App\Http\Controllers\Api\CrudGeneratorController');
        return $controller->callAction('update', [$endpoint, $id, $postdata]);
    });

    Route::delete('/{endpoint}/{id}',function($endpoint,$id){
        $controller = App::make('\App\Http\Controllers\Api\CrudGeneratorController');
        return $controller->callAction('delete', [$endpoint, $id]);
    });
});


Route::group(['prefix' => 'database'], function () {
    Route::get('/',function(){
        $controller = App::make('\App\Http\Controllers\Api\CrudGeneratorController');
        return $controller->callAction('databaseIndex',[]);
    }); 
});