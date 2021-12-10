<?php

use App\Http\Controllers\Admin\offHoursController;

Route::resource('offhours', offHoursController::class)->except(['show']);

Route::post('offhours/offHoursTable', [offHoursController::class, 'offHoursTable'])->name('offhours.offHoursTable');
Route::post('offhours/storepers', [offHoursController::class, 'storepers'])->name('offhours.storepers');
Route::post('offhours/change', [offHoursController::class, 'change'])->name('offhours.change');
Route::post('offhours/delPers', [offHoursController::class, 'delPers'])->name('offhours.delPers');

Route::get('offhours/download/{slug?}', [offHoursController::class, 'download'])->name('offhours.download');

//Route::get('offhours/holiday/{user:id?}', [offHoursController::class, 'holiday'])->name('holidays.holiday');
//Route::post('offhours/holiday/store', [offHoursController::class, 'store'])->name('holiday.store');
//Route::post('offhours/holiday/chose', [offHoursController::class, 'chose'])->name('holiday.chose');
