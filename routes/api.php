<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostinganController;
use App\Http\Controllers\Api\TemanController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\CommentController;
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



Route::group(['middleware' => 'auth:api'], function () {

    Route::post("/user/{user}/addTeman", [UserController::class, 'addTeman']);
    Route::post("/user/{user}/hapusTeman", [UserController::class, 'hapusTeman']);
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/validasi_file_', [Helper::class, 'file_validasi']);
    Route::post('/post_image_', [PostinganController::class, 'post_']);
    Route::get('/user/{name}', [UserController::class, 'user']);
    Route::get('/postingan/teman', [PostinganController::class, 'postingan_teman']);
    Route::get('/user/{user}/notifikasi', [UserController::class, 'notifikasi_']);
    Route::get('/postingan/{postingan}/detail', [PostinganController::class, 'detail_post']);
    Route::get('/postingan/{postingan}/komentar', [CommentController::class, 'komentar_']);
    Route::post('/postingan/{postingan}/komentari', [CommentController::class, 'komentari_']);
    Route::get('/temans', [TemanController::class, 'temans']);
    Route::get('/pesan/{id}', [TemanController::class, 'ambil_pesan_dengan']);
    Route::post('/pesan/kirim', [UserController::class, 'kirim_pesan']);
    Route::get('/users/cari', [UserController::class, 'cari__']);
    Route::post('/notifikasi/update_notifikasi/{postingan}', [UserController::class, 'update_notifikasi_']);
    Route::get('/notifikasi/jumlah_', [UserController::class, 'jumlah_notifikasi_']);
});

Route::post('/postingan/{postingan}/like', [PostinganController::class, 'like']);
Route::post('/postingan/{postingan}/dislike', [PostinganController::class, 'dislike']);
