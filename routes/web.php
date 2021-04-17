<?php

use Illuminate\Support\Facades\Auth;
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
    return redirect(url('/login'));
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', 'DashboardController@index')->name('home');
    Route::resource('/user', 'UserController')->except('show');

    Route::resource('/profile', 'ProfileController')->except('show', 'destroy');

    Route::resource('/item', 'ItemController')->only('create', 'index');
    Route::resource('/equipment', 'EquipmentController')->only('create', 'index');
    Route::resource('/operator', 'OperatorController')->only('create', 'index');
    Route::resource('/vendor', 'VendorController')->only('create', 'index');
    Route::resource('/client', 'ClientController')->only('create', 'index');

    Route::resource('/rental', 'RentalController')->except('create');
    Route::post('rental/datatable', 'RentalController@dataTable');
    Route::post('rental/{rental}/approve', 'RentalController@approve');


    Route::resource('/event', 'EventController')->except('create');
    Route::post('event/datatable', 'EventController@dataTable');
    Route::post('event/{event}/approve', 'RentalController@approve');

    Route::get('letter/{filename}', function ($filename) {
        $path = storage_path('app/letter/' . $filename);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    });
});
