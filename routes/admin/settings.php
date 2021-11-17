<?php

use App\Http\Controllers\Admin\SettingsController;

Route::resource('settings', SettingsController::class)->except(['show']);