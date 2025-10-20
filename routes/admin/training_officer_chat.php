<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrainingOfficer\ChatController;

Route::prefix('training_officer_chat')->group(function () {
    Route::get('/index', [ChatController::class, 'index'])->name('training_officer_chat.index');

    Route::get('/updateNotification/{student_id}', [ChatController::class, 'updateNotification'])->name('training_officer_chat.updateNotification')->where(['student_id' => '[0-9]+']);

    Route::get('/detail', [ChatController::class, 'detail'])->name('training_officer_chat.detail');
});
