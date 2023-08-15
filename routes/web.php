<?php

use App\Http\Controllers\PostController;
use App\RMVC\Route\Route;

Route::get('/posts', [PostController::class, 'index'])->name('posts')->middleware('auth');
