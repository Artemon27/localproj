<?php

use App\Http\Controllers\Admin\UserController;

Route::post('users/search', [UserController::class, 'search'])->name('users.search');
Route::get('users/search', [UserController::class, 'search'])->name('users.search');
