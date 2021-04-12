<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::resource('barang', 'Api\BarangController')->except('create', 'index');
    Route::post('barang/datatable', 'Api\BarangController@dataTable');
    Route::get('barang/max-kode/{kode}', 'Api\BarangController@maxKode');


    Route::resource('jasa', 'Api\JasaController')->except('create', 'index');
    Route::post('jasa/datatable', 'Api\JasaController@dataTable');



    Route::get('generate-barcode/{kode}', 'Api\Controller@generateBarcode');

    Route::get('check-visible-barang', 'Api\Controller@checkVisibleBarang');
    Route::get('check-visible-noreg', 'Api\Controller@checkVisibleNoreg');

    Route::get('lookup-client', 'Api\Controller@lookupClient');
    Route::get('lookup-barang', 'Api\Controller@lookupBarang');




});
