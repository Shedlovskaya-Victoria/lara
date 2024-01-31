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

Route::get('/', [\App\Http\Controllers\LoginController::class,'index'])->name('login.index');
Route::get('/category/{category}', [\App\Http\Controllers\FrontController::class,'postInCategory'])->name('home.category');




Route::get('/show', [UserController::class,'index']);
Route::prefix('admin')->group(function () {
    Route::resource('/category', \App\Http\Controllers\CategoryController::class);
    Route::resource('/posts', \App\Http\Controllers\PostController::class);
    Route::resource('/login', \App\Http\Controllers\LoginController::class);
});
    Route::get('/index', [\App\Http\Controllers\FrontController::class,'index'])->name('home.index');
    Route::get('/article/{front}', [\App\Http\Controllers\FrontController::class,'show'])->name('home.show');



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
