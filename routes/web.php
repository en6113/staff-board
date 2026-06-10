<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::delete('news/{news}/hide', [NewsController::class, 'hide'])->name('news.hide');
    Route::patch('news/{news}/unhide', [NewsController::class, 'unhide'])->name('news.unhide');
    Route::resource('news', NewsController::class);

    Route::delete('posts/{post}/hide', [PostController::class, 'hide'])->name('posts.hide');
    Route::resource('posts', PostController::class);
});