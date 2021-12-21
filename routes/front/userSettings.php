<?php

use App\Http\Controllers\UserSettingController;

Route::post('USettings/{id}/toggle', [UserSettingController::class, 'toggle'])->name('USettings.toggle');