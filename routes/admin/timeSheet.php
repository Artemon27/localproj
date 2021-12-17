<?php

use App\Http\Controllers\Admin\timeSheetController;

Route::resource('timeSheet', timeSheetController::class)->except(['show']);

// Route::post('offhours/offHoursTable', [offHoursController::class, 'offHoursTable'])->name('offhours.offHoursTable');
// Route::post('offhours/storepers', [offHoursController::class, 'storepers'])->name('offhours.storepers');
// Route::post('offhours/change', [offHoursController::class, 'change'])->name('offhours.change');
// Route::post('offhours/delPers', [offHoursController::class, 'delPers'])->name('offhours.delPers');
//
Route::get('timeSheet/timeSheetpers/{slug?}', [timeSheetController::class, 'timeSheetpers'])->name('timeSheet.timeSheetpers');

Route::get('timeSheet/{user:id?}', [timeSheetController::class, 'timeSheetpers'])->name('timeSheet.timeSheetpers');
Route::post('timeSheet/store', [timeSheetController::class, 'store'])->name('timeSheet.store');
Route::post('timeSheet/chose', [timeSheetController::class, 'chose'])->name('timeSheet.chose');
