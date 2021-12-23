<?php

use App\Http\Controllers\Admin\UserController;

Route::post('users/search', [UserController::class, 'search'])->name('users.search');
Route::post('users/addUser', [UserController::class, 'addUser'])->name('users.addUser');
Route::post('users/CreateTableUsers', [UserController::class, 'CreateTableUsers'])->name('users.CreateTableUsers');
Route::get('users/search', [UserController::class, 'search'])->name('users.search');
