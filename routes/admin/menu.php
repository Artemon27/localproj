<?php

use App\Http\Controllers\Admin\MainController;

Route::resource('main', MainController::class)->except(['show']);
