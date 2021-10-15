<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HolidayController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('holiday', [HolidayController::class, 'index']);


Auth::routes([
    'login'    => true,
    'logout'   => true,
    'register' => false,
    'reset'    => false,
    'confirm'  => false,
    'verify'   => false,
]);

Route::get('/register', function () {
    return redirect('/');
});

Route::group([
    'prefix' => 'admin',
], function () {
    Route::get('/login', [LoginController::class, 'showLoginForm']);
    Route::post('/login', [LoginController::class, 'login'])->name('admin-login');
    Route::post('/logout', [LoginController::class, 'logout'])
        ->middleware('auth')
        ->name('admin-logout');

    Route::view('/', 'admin.main')->middleware('auth')->name('admin');

    Route::group([
        'middleware' => 'auth',
        'as' => 'admin.'
    ], function () {
        Route::resource('users', UserController::class)->except(['show']);        
    });
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
