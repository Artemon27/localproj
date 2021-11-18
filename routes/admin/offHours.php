<?php

use App\Http\Controllers\Admin\offHoursController;

Route::resource('offhours', offHoursController::class)->except(['show']);

Route::post('offhours/offHoursTable', [offHoursController::class, 'offHoursTable'])->name('offhours.offHoursTable');

Route::get('offhours/download/{slug?}', [offHoursController::class, 'download'])->name('offhours.download');

//Route::get('offhours/holiday/{user:id?}', [offHoursController::class, 'holiday'])->name('holidays.holiday');
//Route::post('offhours/holiday/store', [offHoursController::class, 'store'])->name('holiday.store');
//Route::post('offhours/holiday/chose', [offHoursController::class, 'chose'])->name('holiday.chose');
