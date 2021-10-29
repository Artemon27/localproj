<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\UserController;

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


require(__DIR__ . '/front/holiday.php');


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
        require(__DIR__ . '/admin/holidays.php');
        require(__DIR__ . '/admin/holidaydays.php');
    });    
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', function() {
    return view('home');
})->name('home')->middleware('auth');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/ldap', [App\Http\Controllers\UserController::class, 'index']);
