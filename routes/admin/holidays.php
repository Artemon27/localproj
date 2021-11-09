<?php

use App\Http\Controllers\Admin\HolidayController;

Route::resource('holidays', HolidayController::class)->except(['show']);
Route::get('/holitable', [HolidayController::class, 'holiTable']);
Route::get('/download', [HolidayController::class, 'download']);