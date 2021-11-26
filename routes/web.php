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

Route::get('/home', function () {
    return redirect('/holiday');
});


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
    'middleware' => 'admin',
], function () {
    Route::get('/login', [LoginController::class, 'showLoginForm']);
    Route::post('/login', [LoginController::class, 'login'])->name('admin-login');
    Route::post('/logout', [LoginController::class, 'logout'])
        ->middleware('auth')
        ->name('admin-logout');

    Route::post('/updateldap', [UserController::class, 'updateldap'])->name('users-update');

    Route::view('/', 'admin.main')->middleware('auth')->name('admin');

    Route::get('/mig/ra/te', [UserController::class, 'migrate']);
    
    Route::group([
        'middleware' => 'auth',
        'as' => 'admin.'
    ], function () {
        Route::resource('users', UserController::class)->except(['show']);
        require(__DIR__ . '/admin/holidays.php');
        require(__DIR__ . '/admin/settings.php');
        require(__DIR__ . '/admin/holidaydays.php');
        require(__DIR__ . '/admin/offHours.php');
        require(__DIR__ . '/admin/CreateKey.php');
        require(__DIR__ . '/admin/menu.php');
    });
});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth','admin']], function () {
     \UniSharp\LaravelFilemanager\Lfm::routes();
 });
 
Route::group([
        'middleware' => 'auth'
    ], function () {
        require(__DIR__ . '/front/holiday.php');
        require(__DIR__ . '/front/offHours.php');
        require(__DIR__ . '/front/timeSheet.php');
        require(__DIR__ . '/front/menu.php');
    });

Auth::routes();



Route::get('/ldap', [App\Http\Controllers\UserController::class, 'index']);
