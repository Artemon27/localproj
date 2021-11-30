<?php

use App\Http\Controllers\MainController;

Route::get('/', [MainController::class, 'index'])->name('main.index');
