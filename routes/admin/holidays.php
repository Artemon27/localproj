<?php

use App\Http\Controllers\Admin\HolidayController;

Route::resource('holidays', HolidayController::class)->except(['show']);