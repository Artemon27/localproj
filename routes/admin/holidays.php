<?php

use App\Http\Controllers\Admin\HolidayController;

Route::resource('holidays', HolidayController::class)->except(['show']);

Route::post('holidays/holitable', [HolidayController::class, 'holiTable'])->name('holidays.holiTable');

Route::get('holidays/download/{slug?}', [HolidayController::class, 'download'])->name('holidays.download');

Route::get('holidays/holiday/{user:id?}', [HolidayController::class, 'holiday'])->name('holidays.holiday');
Route::post('holidays/holiday/store', [HolidayController::class, 'store'])->name('holiday.store');
Route::post('holidays/holiday/chose', [HolidayController::class, 'chose'])->name('holiday.chose');