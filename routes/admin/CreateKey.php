<?php

use App\Http\Controllers\Admin\CreateKeyController;

Route::resource('createkey', CreateKeyController::class)->except(['show']);



Route::get('createkey/download/{slug?}', [CreateKeyController::class, 'download'])->name('createkey.download');

//Route::get('offhours/holiday/{user:id?}', [offHoursController::class, 'holiday'])->name('holidays.holiday');
Route::post('createkey/store', [CreateKeyController::class, 'store'])->name('createkey.store');
Route::post('createkey/storepers', [CreateKeyController::class, 'storepers'])->name('createkey.storepers');
Route::post('createkey/delpers', [CreateKeyController::class, 'delpers'])->name('createkey.delpers');
Route::post('createkey/CreateKeyTable', [CreateKeyController::class, 'CreateKeyTable'])->name('createkey.CreateKeyTable');
Route::post('createkey/deleteRoom', [CreateKeyController::class, 'deleteRoom'])->name('createkey.deleteRoom');
//Route::post('offhours/holiday/chose', [offHoursController::class, 'chose'])->name('holiday.chose');
