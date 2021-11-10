<?php

use App\Http\Controllers\Admin\HolidayController;

Route::resource('holidays', HolidayController::class)->except(['show']);
Route::post('holidays/holitable', [HolidayController::class, 'holiTable'])->name('holidays.holiTable');

Route::get('holidays/download/{slug?}', [HolidayController::class, 'download'])->name('holidays.download');