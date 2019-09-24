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

Route::get('/nueva','prediccion3Controller@arreglar')->name('arreglar');
Route::get('/todos','prediccion2Controller@todos')->name('todos');
Route::get('/Acertados','prediccion2Controller@acertados')->name('acertados');
Route::get('/prediccion','prediccion2Controller@index');
Route::get('/predicciones','prediccion3Controller@index');
Route::post('/predicciones/excel','prediccion3Controller@importarExcel')->name('importar.excel');
