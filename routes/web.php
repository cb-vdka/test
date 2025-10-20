<?php


use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\Authenticationed;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/news', 'news')->name('news');
Route::view('/education', 'education')->name('education');
Route::view('/activities', 'activities')->name('activities');
Route::view('/library', 'library')->name('library');
Route::view('/policies', 'policies')->name('policies');
Route::view('/contact', 'contact')->name('contact');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Route::prefix('login')->middleware(Authenticationed::class)->group(function () {
//     Route::get('/{role_id}', [LoginController::class, 'index'])->name('login.index')->where(['role_id' => '[0-9]+']);

//     Route::post('/send_otp', [LoginController::class, 'send_otp'])->name('login.send_otp');

//     Route::get('/enter_otp', [LoginController::class, 'enter_otp'])->name('login.enter_otp');

//     Route::post('/confirm_otp', [LoginController::class, 'confirm_otp'])->name('login.confirm_otp');
// });

Route::prefix('login')->middleware(Authenticationed::class)->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login.index');
    Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('login.authenticate');
});Route::get('/auth/google', [LoginController::class, 'redirectToGoogle'])->name('auth.google');

Route::get('/auth/google/callback', [LoginController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// Include admin routes
require __DIR__.'/admin.php';

// Include teacher routes
require __DIR__.'/teacher.php';
