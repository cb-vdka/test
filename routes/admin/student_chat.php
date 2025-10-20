<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student\StudentChatController;

Route::prefix('student_chat')->group(function () {
    Route::get('/index', [StudentChatController::class, 'index'])->name('student_chat.index');

    Route::post('/store', [StudentChatController::class, 'store'])->name('student_chat.store');
});
