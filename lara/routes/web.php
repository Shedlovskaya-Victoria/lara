<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\UserController;
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

Route::get('/', [\App\Http\Controllers\FrontController::class,'index'])->name('home');




Route::get('/show', [UserController::class,'index']);
Route::resource('/category', \App\Http\Controllers\CategoryController::class);
Route::resource('/posts', \App\Http\Controllers\PostController::class);

