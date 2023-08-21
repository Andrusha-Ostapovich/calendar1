<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FullCalenderController;
use App\Http\Controllers\UserController;

Route::resource('user', UserController::class);

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('full-calender');


Route::prefix('{user}')->group(function () {
    Route::get('profile', [UserController::class, 'profile'])->name('user.profile');
    Route::get('profile/edit', [UserController::class, 'editProfile'])->name('user.profile.edit');
    Route::put('profile/update', [UserController::class, 'updateProfile'])->name('user.profile.update');
});



Route::middleware(['auth'])->group(function () {
    Route::get('full-calender', [FullCalenderController::class, 'index']);
    Route::post('full-calender/action', [FullCalenderController::class, 'action']);
    Route::post('/full-calender/update-event', [FullCalenderController::class, 'updateEvents']);
});
