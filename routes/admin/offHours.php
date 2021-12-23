<?php

use App\Http\Controllers\Admin\offHoursController;

Route::resource('offhours', offHoursController::class)->except(['show']);
Route::get('offhours/download/{slug?}', [offHoursController::class, 'download'])->name('offhours.download');
Route::post('offhours/offHoursTable', [offHoursController::class, 'offHoursTable'])->name('offhours.offHoursTable');
Route::post('offhours/storepers', [offHoursController::class, 'storepers'])->name('offhours.storepers');
Route::post('offhours/change', [offHoursController::class, 'change'])->name('offhours.change');
Route::post('offhours/delPers', [offHoursController::class, 'delPers'])->name('offhours.delPers');
Route::get('offhours/offhourpers', [offHoursController::class, 'offhourpers'])->name('offhours.offhourpers');
Route::get('offhours/{user:id?}', [offHoursController::class, 'offhourpers'])->name('offhours.offhourpers');
Route::post('offhours/chose', [offHoursController::class, 'chose'])->name('offhours.chose');
