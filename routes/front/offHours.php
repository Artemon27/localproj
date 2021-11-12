<?php

use App\Http\Controllers\offHoursController;

Route::resource('offhours', offHoursController::class)->except(['show'])->name('index', 'offhours');
