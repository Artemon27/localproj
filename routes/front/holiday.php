<?php

use App\Http\Controllers\HolidayController;

Route::resource('holiday', HolidayController::class)->except(['show'])->name('index', 'holiday');
Route::get('holiday/colors', [HolidayController::class, 'colors'])->name('holiday.colors');
Route::post('holiday/addcolors', [HolidayController::class, 'addcolors'])->name('holiday.addcolors');