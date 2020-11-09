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

Route::resource('catalog', 'App\Http\Controllers\CatalogController');
//Areas de Responsabilidad
Route::resource('arearesp', 'App\Http\Controllers\AreaRespController');
Route::get('arearesp_ajax',[App\Http\Controllers\AreaRespController::class, 'arearespAjax']);
//Centros de análisis
Route::resource('costCenters', 'App\Http\Controllers\CostCenterController');
Route::get('cost_centers_ajax',[App\Http\Controllers\CostCenterController::class, 'costCenterAjax']);
//Countries
Route::resource('countries', 'App\Http\Controllers\CountryController');
Route::get('countries_ajax',[App\Http\Controllers\CountryController::class, 'countriesAjax']);
//Ciudades
Route::resource('cities', 'App\Http\Controllers\CityController');
Route::get('cities_ajax',[App\Http\Controllers\CityController::class, 'citiesAjax']);
//Contacts
Route::resource('contacts', 'App\Http\Controllers\ContactController');
Route::get('contacts_ajax',[App\Http\Controllers\ContactController::class, 'contactsAjax']);
//Exchange Rates
Route::resource('exchangerates', 'App\Http\Controllers\ExchangeRateController');
Route::get('exchangerates_ajax',[App\Http\Controllers\ExchangeRateController::class, 'exchangeratesAjax']);