<?php

use App\Http\Controllers\Admin\timeSheetController;

Route::resource('timeSheet', timeSheetController::class)->except(['show']);

// Route::post('offhours/offHoursTable', [offHoursController::class, 'offHoursTable'])->name('offhours.offHoursTable');
// Route::post('offhours/storepers', [offHoursController::class, 'storepers'])->name('offhours.storepers');
// Route::post('offhours/change', [offHoursController::class, 'change'])->name('offhours.change');
// Route::post('offhours/delPers', [offHoursController::class, 'delPers'])->name('offhours.delPers');
//
Route::get('timeSheet/download/{slug?}', [timeSheetController::class, 'download'])->name('timeSheet.download');

//Route::get('offhours/holiday/{user:id?}', [offHoursController::class, 'holiday'])->name('holidays.holiday');
//Route::post('offhours/holiday/store', [offHoursController::class, 'store'])->name('holiday.store');
//Route::post('offhours/holiday/chose', [offHoursController::class, 'chose'])->name('holiday.chose');
