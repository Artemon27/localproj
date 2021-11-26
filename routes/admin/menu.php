<?php

use App\Http\Controllers\Admin\MainController;

Route::resource('main', HolidayController::class)->except(['show']);
