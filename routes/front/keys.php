<?php

use App\Http\Controllers\keysController;

Route::resource('keys', keysController::class)->except(['show'])->name('index', 'keys');
