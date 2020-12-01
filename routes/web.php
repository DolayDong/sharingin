<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\App\HomeController;
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
    return view('welcome');
})->name('login')->middleware('guest');
Route::get('verifikasi_', [AuthController::class, 'verifikasi']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth')->group(function(){
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('{any}', [HomeController::class, 'index'])->name('Home')->where('any', '^(?!api).*$');
});

