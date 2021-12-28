<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\HolidayController;
use App\Http\Controllers\API\OffHoursController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\UserResource;
use App\Http\Resources\HolidaysResource;
use App\Http\Resources\KeysResource;
use App\Http\Resources\OffhoursResource;
use App\Http\Resources\TimesheetResource;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'login' => 'required|string',
        'password' => 'required',
        'device_name' => 'required',
    ]);
    $user = User::where('sAMAccountName', $request->login)->first();
    if (! $user || ! Auth::attempt(['username' => $request->login, 'password' => $request->password])) {
        throw ValidationException::withMessages([
            'login' => ['Неправильный логин или пароль'],
        ]);
    }
    return $user->createToken($request->device_name)->plainTextToken;
});

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::group([
    'middleware' => 'auth:sanctum',
], function () {
    Route::get('user', function (Request $request) {
        return new UserResource($request->user());
    });
    Route::get('holidays', function (Request $request) {
        return HolidaysResource::collection($request->user()->holidays);
    });
    Route::get('offhours', function (Request $request) {
        return OffhoursResource::collection($request->user()->off_hours);
    });
    Route::get('keys', function (Request $request) {
        return KeysResource::collection($request->user()->rooms);
    });
    //Route::get('/timesheet', function (Request $request) {
    //    return TimesheetResource::collection($request->user()->holidays);
    //});
    Route::post('holidays', [HolidayController::class, 'show'])->name('holiday.show');
    Route::post('holiday/store', [HolidayController::class, 'store'])->name('holiday.store');
    
    Route::post('offhours', [OffHoursController::class, 'show'])->name('offhours.show');
    Route::post('offhours/store', [OffHoursController::class, 'store'])->name('offhours.store');
    Route::delete('offhours/delete', [OffHoursController::class, 'delete'])->name('offhours.delete');
    Route::post('offhours/showday', [OffHoursController::class, 'showDay'])->name('offhours.showDay');
});