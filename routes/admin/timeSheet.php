<?php

use App\Http\Controllers\Admin\timeSheetController;

Route::resource('timeSheet', timeSheetController::class)->except(['show']);


Route::get('timeSheet/timeSheetpers/{slug?}', [timeSheetController::class, 'timeSheetpers'])->name('timeSheet.timeSheetpers');

Route::get('timeSheet/{user:id?}', [timeSheetController::class, 'timeSheetpers'])->name('timeSheet.timeSheetpers');
Route::post('timeSheet/store', [timeSheetController::class, 'store'])->name('timeSheet.store');
Route::post('timeSheet/chose', [timeSheetController::class, 'chose'])->name('timeSheet.chose');
