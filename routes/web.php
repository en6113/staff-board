<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SentListController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // 送信一覧
    Route::get('/sent', [SentListController::class, 'index'])->name('sent.index');

    // お知らせ関係
    Route::delete('news/{news}/hide', [NewsController::class, 'hide'])->name('news.hide');
    Route::patch('news/{news}/unhide', [NewsController::class, 'unhide'])->name('news.unhide');
    Route::resource('news', NewsController::class);

    // 掲示・回覧関係
    Route::delete('posts/{post}/hide', [PostController::class, 'hide'])->name('posts.hide');
    Route::patch('posts/{post}/unhide', [PostController::class, 'unhide'])->name('posts.unhide');
    Route::resource('posts', PostController::class);

    // チャット関係
    Route::post('/rooms/{room}/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::resource('rooms', RoomController::class)->only('index', 'create', 'store', 'show');
});