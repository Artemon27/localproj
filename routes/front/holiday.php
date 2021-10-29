<?php

use App\Http\Controllers\HolidayController;

Route::resource('holiday', HolidayController::class)->except(['show']);