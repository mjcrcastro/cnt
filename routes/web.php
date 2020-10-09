<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AreaRespController;

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

Route::resource('catalog', 'App\Http\Controllers\CatalogController');
Route::resource('arearesp', 'App\Http\Controllers\AreaRespController');
Route::get('arearesp_ajax',[AreaRespController::class, 'arearespAjax']);