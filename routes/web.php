<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KariawanController;


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

// Route::resource('/', KariawanController::class);
Route::get('/karyawan', [KariawanController::class, 'index'])->name('karyawan.index');
Route::post('/karyawan/store', [KariawanController::class, 'store'])->name('karyawan.store');
Route::get('/karyawan/data', [KariawanController::class, 'data'])->name('karyawan.data');


// Route::post('store-kariawan', [KariawanController::class, 'store']);
// Route::post('edit-kariawan', [KariawanController::class, 'edit']);
// Route::post('delete-kariawan', [KariawanController::class, 'destroy']);

