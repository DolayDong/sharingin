<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostinganController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Helper;
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

Route::get('/users_data_', [UserController::class, 'users_data_']);
Route::post('/register_', [AuthController::class, 'registrasi_']);



Route::group(['middleware' => 'auth:api'], function() {  
    
    Route::post("/user/{user}/addTeman", [UserController::class, 'addTeman']);  
    Route::post("/user/{user}/hapusTeman", [UserController::class, 'hapusTeman']);  
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/validasi_file_', [Helper::class, 'file_validasi']);
    Route::post('/post_image_', [PostinganController::class, 'post_']);
    Route::get('/user/{name}', [UserController::class, 'user']);
    Route::get('/postingan/teman', [PostinganController::class, 'postingan_teman']);
});


