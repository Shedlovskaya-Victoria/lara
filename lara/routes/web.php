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

Route::prefix('blog')->group(function (){
    Route::get('/', [\App\Http\Controllers\FrontController::class, 'index'])->name('home.index');
    Route::get('/post/{post}', [\App\Http\Controllers\FrontController::class, 'show'])->name('home.show');
    Route::get('/category/{category}', [\App\Http\Controllers\FrontController::class, 'postInCategory'])->name('home.category');
    Route::get('/tag/{tag}', [\App\Http\Controllers\FrontController::class, 'postInTag'])->name('home.tag');
    Route::resource('user',\App\Http\Controllers\UserController::class);
});
Auth::routes();

Route::resource('/', \App\Http\Controllers\LoginController::class);

Route::prefix('/admin')->group(function () {
    Route::resource('categories', \App\Http\Controllers\CategoryController::class);
    Route::resource('posts', \App\Http\Controllers\PostController::class);
    Route::resource('tags', App\Http\Controllers\TagController::class);
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
})->middleware('auth');



