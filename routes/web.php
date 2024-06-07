<?php

use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('form');
})->name('index');

Route::group(['as' => 'api.', 'prefix' => 'api'], function () {
    Route::group(['as' => 'lead.', 'prefix' => 'lead'], function () {
        Route::put('/', [TransactionController::class, 'put'])->name('put');
    });
});
