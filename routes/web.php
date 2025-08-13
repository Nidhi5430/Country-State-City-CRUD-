<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\CityController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return redirect()->route('countries.index');
});

Route::resource('countries', CountryController::class);
// Route::resource('states'->name('states.edit'), StateController::class);
Route::resource('states', StateController::class)->names(['edit' => 'states.edit',]);
Route::resource('cities', CityController::class);

// AJAX routes (GET)
Route::get('ajax/states/{country}', [StateController::class, 'statesByCountry'])->name('ajax.states');
Route::get('ajax/cities/{state}', [CityController::class, 'citiesByState'])->name('ajax.cities');

