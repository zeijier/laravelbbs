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
//命名路由可以方便地为指定路由生成 URL 或者重定向。通过在路由定义上链式调用 name 方法指定路由名称：
Route::get('/','PageController@root')->name('root');
