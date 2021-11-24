<?php

use App\Http\Controllers\timeSheetController;

Route::resource('timeSheet', timeSheetController::class)->except(['show'])->name('index', 'timeSheet');
