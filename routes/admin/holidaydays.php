<?php

use App\Http\Controllers\Admin\HolidayDaysController;

Route::resource('holidaydays', HolidayDaysController::class)->except(['show']);