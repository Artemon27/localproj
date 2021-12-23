<?php

use App\Http\Controllers\Admin\CreateKeyController;

Route::resource('createkey', CreateKeyController::class)->except(['show']);


Route::get('createkey/download/{slug?}', [CreateKeyController::class, 'download'])->name('createkey.download');


Route::post('createkey/store', [CreateKeyController::class, 'store'])->name('createkey.store');
Route::post('createkey/change', [CreateKeyController::class, 'change'])->name('createkey.change');
Route::post('createkey/changepers', [CreateKeyController::class, 'changepers'])->name('createkey.changepers');
Route::post('createkey/storepers', [CreateKeyController::class, 'storepers'])->name('createkey.storepers');
Route::post('createkey/delpers', [CreateKeyController::class, 'delpers'])->name('createkey.delpers');
Route::post('createkey/CreateKeyTable', [CreateKeyController::class, 'CreateKeyTable'])->name('createkey.CreateKeyTable');
Route::post('createkey/deleteRoom', [CreateKeyController::class, 'deleteRoom'])->name('createkey.deleteRoom');
Route::post('createkey/search', [CreateKeyController::class, 'search'])->name('createkey.search');
Route::post('createkey/{id}/toggle', [CreateKeyController::class, 'toggle'])->name('roompersons.toggle');
